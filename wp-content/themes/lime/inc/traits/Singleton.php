<?php
namespace Inc\Traits;
trait Singleton
{
          private static ?array $instance = null;
          // try to use static insted of get_called_class
          public static function getInstance()
          {
                    $called_class = get_called_class();
                    if (self::$instance[$called_class] === null) {
                              self::$instance[$called_class] = new $called_class();
                    }
                    return self::$instance[$called_class];
          }

          /**
           * Disabled constructor.
           *
           * @codeCoverageIgnore
           */
          private function __construct()
          {

          }
          /**
           * Disabled clone.
           *
           * @codeCoverageIgnore
           */
          protected function __clone()
          {
          }
}