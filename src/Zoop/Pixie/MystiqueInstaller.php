<?php

namespace Zoop\Pixie;

use Composer\Repository\InstalledRepositoryInterface;
use Composer\Package\PackageInterface;

class MystiqueInstaller extends AbstractInstaller
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
        $this->add();
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        $this->remove();
        parent::update($repo, $initial, $target);
        $this->add();
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->remove();
        parent::uninstall($repo, $package);
    }


    protected function add(){
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['zoop-js-path'])) {
                $this->link(
                    getcwd() . '/' . $extra['zoop-js-path'] . '/mystique',
                    $this->vendorDir . '/zoopcommerce/mystique/js/mystique'
                );
            }
        }
    }

    protected function remove(){
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['zoop-js-path'])) {
                $this->unlink(getcwd() . '/' . $extra['zoop-js-path'] . '/mystique');
            }
        }
    }
}