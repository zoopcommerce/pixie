<?php

namespace Zoop\Pixie;

use Composer\Installer\LibraryInstaller;

class AbstractInstaller extends LibraryInstaller
{

    protected function link($target, $source)
    {
        if (!file_exists(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }

        if (! function_exists('symlink') || !symlink($target, $source)) {
            //if symlink fails, like on old windows systems, then restort to copy
            $this->recurseCopy($source, $target);
        }
    }

    protected function unlink($target)
    {
        if (!file_exists($target)) {
            return;
        }

        if (is_link($target)) {
            unlink($target);
        } else {
            //if symlink fails, like on old windows systems
            $this->recurseDelete($target);
            rmdir($target);
        }
    }

    public function recurseDelete($path)
    {
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($it as $file) {
            if (in_array($file->getBasename(), array('.', '..'))) {
                continue;
            } elseif ($file->isDir()) {
                rmdir($file->getPathname());
            } elseif ($file->isFile() || $file->isLink()) {
                unlink($file->getPathname());
            }
        }
    }

    protected function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
