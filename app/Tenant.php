<?php
namespace App;

use Illuminate\Support\Facades\Artisan;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
/**
 * @property Website website
 * @property Hostname hostname
 */

class Tenant
{
    /**
     * Tenant constructor.
     *
     * @param \Hyn\Tenancy\Models\Website|null  $website
     * @param \Hyn\Tenancy\Models\Hostname|null $hostname
     */
    public function __construct(Website $website = null, Hostname $hostname = null)
    {
        $this->website = $website ?? $sub->website;
        $this->hostname = $hostname ?? $sub->websites->hostnames->first();
    }

    /**
     *
     */
    public function delete()
    {
        app(HostnameRepository::class)->delete($this->hostname, true);
        app(WebsiteRepository::class)->delete($this->website, true);
    }

    /**
     * @param $fqdn
     *
     * @return \App\Tenant
     */
    public static function create($fqdn): Tenant
    {
        // Create New Website
        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        // associate the website with a hostname
        $hostname = new Hostname;
        $hostname->fqdn = $fqdn;
        app(HostnameRepository::class)->attach($hostname, $website);

        // make hostname current
        app(Environment::class)->tenant($website);

        Artisan::call('passport:install');

        return new Tenant($website, $hostname);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function tenantExists($name)
    {
        return Hostname::where('fqdn', $name)->exists();
    }
}