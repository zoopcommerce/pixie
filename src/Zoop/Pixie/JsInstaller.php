<?php

namespace Zoop\Pixie;

use Composer\Repository\InstalledRepositoryInterface;
use Composer\Package\PackageInterface;

class JsInstaller extends AbstractInstaller
{
    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'zoop-js';
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);
        $this->add($package);
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        $this->remove($initial);
        parent::update($repo, $initial, $target);
        $this->add($target);
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->remove($package);
        parent::uninstall($repo, $package);
    }


    protected function add($package){
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['zoop-js-path'])) {
                $this->link(
                    getcwd() . '/' . $extra['zoop-js-path'] . '/' . explode('/', $package->getPrettyName())[1],
                    $this->getInstallPath($package)
                );
            }
        }
    }

    protected function remove($package){
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['zoop-js-path'])) {
                $this->unlink(getcwd() . '/' . $extra['zoop-js-path'] . explode('/', $package->getPrettyName())[1]);
            }
        }
    }
}