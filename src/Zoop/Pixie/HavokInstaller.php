<?php

namespace Zoop\Pixie;

use Composer\Repository\InstalledRepositoryInterface;
use Composer\Package\PackageInterface;

class HavokInstaller extends AbstractInstaller
{
    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'zoop-havok';
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
        parent::update($repo, $package);
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
                    getcwd() . '/' . $extra['zoop-js-path'] . '/havok',
                    $this->vendorDir . '/zoopcommerce/havok'
                );
                $this->link(
                    getcwd() . '/' . $extra['zoop-js-path'] . '/dojo',
                    $this->vendorDir . '/dojo/dojo'
                );
                $this->link(
                    getcwd() . '/' . $extra['zoop-js-path'] . '/dijit',
                    $this->vendorDir . '/dojo/dijit'
                );
                $this->link(
                    getcwd() . '/' . $extra['zoop-js-path'] . '/utils',
                    $this->vendorDir . '/dojo/utils'
                );
            }
        }
    }

    protected function remove(){
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['zoop-js-path'])) {
                $this->unlink(getcwd() . '/' . $extra['zoop-js-path'] . '/havok');
                $this->unlink(getcwd() . '/' . $extra['zoop-js-path'] . '/dojo');
                $this->unlink(getcwd() . '/' . $extra['zoop-js-path'] . '/dijit');
                $this->unlink(getcwd() . '/' . $extra['zoop-js-path'] . '/utils');
            }
        }
    }
}