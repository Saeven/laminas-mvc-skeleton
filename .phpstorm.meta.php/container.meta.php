<?php

namespace PHPSTORM_META {

    override(\Interop\Container\ContainerInterface::get(0),
        map([
            '' => '@',
        ]));

    override(\Interop\Container\ContainerInterface::build(0, 1),
        map([
            '' => '@',
        ]));

    override(use Laminas\Form\FormElementManager::get(0),
        map([
            '' => '@',
        ]));
}