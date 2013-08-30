<?php

namespace Zoop\Pixie;

use Composer\Installer\LibraryInstaller;

class AbstractInstaller extends LibraryInstaller
{

    protected function link($source, $dest)
    {
        if (!file_exists(dirname($dest))) {
            mkdir(dirname($dest), 0777, true);
        }

        $done = false;
        if (function_exists('symlink')){
            try {
                if (symlink($source, $dest)){
                    $done = true;
                }
            } catch (\Exception $ex) {
                //symlink failed
            }
        }

        if (! $done) {
            //if symlink fails, like on old windows systems, or some VM shared folders then restort to copy
            $this->recurseCopy($source, $dest);
        }
    }

    protected function unlink($dest)
    {
        if (!file_exists($dest)) {
            return;
        }

        if (is_link($dest)) {
            unlink($dest);
        } else {
            //if symlink fails, like on old windows systems
            $this->recurseDelete($dest);
            rmdir($dest);
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

    protected function recurseCopy($source, $dest)
    {
        $dir = opendir($source);
        @mkdir($dest);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($source . '/' . $file)) {
                    $this->recurseCopy($source . '/' . $file, $dest . '/' . $file);
                } else {
                    copy($source . '/' . $file, $dest . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
