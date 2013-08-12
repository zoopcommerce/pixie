<?php

namespace Zoop\Pixie;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class MystiqueInstaller extends LibraryInstaller
{

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'zoop-mystique';
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['zoop-public-path'])) {
                //symlink();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);
    }
}