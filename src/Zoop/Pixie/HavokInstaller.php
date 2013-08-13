<?php

namespace Zoop\Pixie;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

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