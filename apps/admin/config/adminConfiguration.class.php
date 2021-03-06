<?php

class adminConfiguration extends sfApplicationConfiguration
{
    /**
     * Config
     */
    public function configure()
    {
    }

    /**
     * Init
     *
     * Все конфиги инициализированы, автозагрузка подключена
     * Фабрики НЕ инициализированы
     */
    public function initialize()
    {
    }

    /**
     * Настройки Doctrine
     */
    public function configureDoctrine(Doctrine_Manager $manager)
    {
        parent::configureDoctrine($manager);

        if ('test' == $this->getEnvironment()) {
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, new Doctrine_Cache_Array());
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE_LIFESPAN, 0);
        } else {
            $servers = array(
                'host'       => 'localhost',
                'port'       => 11211,
                'persistent' => true
            );

            $cacheDriver = new Doctrine_Cache_Memcache(array(
                 'servers'     => $servers,
                 'compression' => true,
            ));

            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE_LIFESPAN, 600); //10m
        }
    }
}
