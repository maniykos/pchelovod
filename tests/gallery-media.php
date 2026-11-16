<?php

// Run inside the application container: php tests/gallery-media.php
// Uses a disposable database and upload directory, never the site's content.
use App\Http\Controllers\Admin\GalleryController;
use App\Models\GalleryItem;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$suffix = bin2hex(random_bytes(8));
$root = storage_path('framework/testing/gallery-'.$suffix);
config([
    'database.connections.mongodb.database' => 'gallery_test_'.$suffix,
    'filesystems.disks.public.root' => $root,
]);
DB::purge('mongodb');
Storage::forgetDisk('public');
File::ensureDirectoryExists($root);
$video = $root.'/sample.mp4';
$image = $root.'/sample.png';
$invalid = $root.'/invalid.mp4';
file_put_contents($video, pack('N', 24).'ftypmp42'.pack('N', 0).'mp42isom');
file_put_contents($image, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aN3sAAAAASUVORK5CYII='));
file_put_contents($invalid, '<?php echo "not a video";');
$controller = new GalleryController;
$checks = 0;
$status = 0;
$check = function (bool $condition, string $message) use (&$checks): void {
    if (! $condition) {
        throw new RuntimeException($message);
    }
    $checks++;
};
$request = function (string $method, ?string $file = null, array $fields = []): Request {
    return Request::create('/admin/gallery', $method, $fields + [
        'title_ru' => 'Тест', 'title_en' => 'Test', 'is_published' => '1',
    ], [], $file ? ['image' => new UploadedFile($file, basename($file), null, null, true)] : []);
};
$storedPath = static fn (GalleryItem $item): string => explode('/storage/', $item->image, 2)[1];

try {
    // A valid MP4 must be accepted, stored, and marked as video.
    $controller->store($request('POST', $video));
    $item = GalleryItem::firstOrFail();
    $check($item->media_type === 'video', 'MP4 must be marked as video');
    $oldPath = $storedPath($item);
    $check(Storage::disk('public')->exists($oldPath), 'Video upload must exist');

    // Editing text without a new file must retain both the video and its type.
    $controller->update($request('PUT', null, ['title_ru' => 'Обновлено']), $item);
    $item->refresh();
    $check($item->media_type === 'video' && $storedPath($item) === $oldPath, 'Text edit must preserve video');

    // Replacing a video with an image must change rendering type and remove the old upload.
    $controller->update($request('PUT', $image), $item);
    $item->refresh();
    $check($item->media_type === 'image', 'Image replacement must change media type');
    $check(! Storage::disk('public')->exists($oldPath), 'Replaced video must be deleted');
    $check(Storage::disk('public')->exists($storedPath($item)), 'Replacement image must exist');

    foreach ([$invalid, null] as $file) {
        try {
            $controller->store($request('POST', $file));
            throw new RuntimeException('Invalid or missing upload was accepted');
        } catch (ValidationException $exception) {
            $check(isset($exception->errors()['image']), 'Invalid upload must produce a file validation error');
        }
    }
    $check(GalleryItem::count() === 1, 'Rejected uploads must not create records');

    // Old image records have no media_type and must still display as images.
    $legacy = GalleryItem::create(['image' => '/images/site/orchard.jpg', 'title_ru' => 'Архив', 'title_en' => 'Archive']);
    $html = view('gallery.index', ['gallery' => collect([$item, $legacy])])->render();
    $check(substr_count($html, '<img src=') === 2, 'Legacy and new images must render as images');
    $controller->update($request('PUT', $video), $item);
    $html = view('gallery.index', ['gallery' => collect([$item->fresh(), $legacy])])->render();
    $check(str_contains($html, '<video') && str_contains($html, 'controls'), 'Video must render with playback controls');

    $path = $storedPath($item->fresh());
    $controller->destroy($item);
    $check(! Storage::disk('public')->exists($path), 'Deleting a video must remove its stored file');
    echo "PASS: {$checks} gallery media checks\n";
} catch (Throwable $exception) {
    fwrite(STDERR, get_class($exception).': '.$exception->getMessage()."\n");
    $status = 1;
} finally {
    DB::connection('mongodb')->getDatabase()->drop();
    File::deleteDirectory($root);
}

exit($status);
