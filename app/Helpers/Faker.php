<?php

if (!function_exists('fake')) {
    /**
     * The current Faker instance.
     *
     * @return \Faker\Generator
     */
    function fake()
    {
        return app('Faker\Generator');
    }
}
