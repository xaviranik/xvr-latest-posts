<?php

namespace XVR\Latest_Post;

/**
 * Installer Class
 */
class Installer
{
    /**
     * Plugin runner
     *
     * @return void
     */
    public function run()
    {
        $this->add_version();
    }

    /**
     * Adds plugin version
     */
    public function add_version()
    {
        $installed = get_option('xvr_latest_post_installed');

        if (!$installed) {
            update_option('xvr_latest_post_installed', time());
        }

        update_option('xvr_latest_post_version', XVR_LATEST_POST_VERSION);
    }
}