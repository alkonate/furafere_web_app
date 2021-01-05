<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManagerStatic;

/**
 * [Description resizeThumbnails]
 * allow you to resize an image after been uploaded
 */
class resizeThumbnails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private string $thumbnailpath;
    private string $minifypath;
    private int $size;


    /**
     * @param string $thumbnailpath
     * @param mixed $minifyPath
     * @param int $size
     */
    public function __construct(string $thumbnailpath,$minifyPath,int $size)
    {
        $this->thumbnailpath = $thumbnailpath;
        $this->minifypath = $minifyPath;
        $this->size = $size;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ImageManagerStatic::make($this->thumbnailpath)->resize($this->size,$this->size)->save($this->minifypath);
    }
}
