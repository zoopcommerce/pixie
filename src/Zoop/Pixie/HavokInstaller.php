<?php

namespace Zoop\Pixie;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class HavokInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'zoop-havok';
    }
}