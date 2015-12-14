<?php

namespace SS6\ShopBundle\Tests\Unit\Component\Domain\Config;

use SS6\ShopBundle\Component\Domain\Config\DomainConfig;
use SS6\ShopBundle\Component\Domain\Config\DomainsConfigLoader;
use SS6\ShopBundle\Tests\Test\FunctionalTestCase;

class DomainsConfigLoaderTest extends FunctionalTestCase {

	public function testLoadDomainConfigsFromYaml() {
		$domainsConfigFilepath = $this->getContainer()->getParameter('ss6.domain_config_filepath');
		$domainsUrlsConfigFilepath = $this->getContainer()->getParameter('ss6.domain_urls_config_filepath');
		$domainsConfigLoader = $this->getContainer()->get(DomainsConfigLoader::class);
		/* @var $domainsConfigLoader \SS6\ShopBundle\Component\Domain\Config\DomainsConfigLoader */

		$domainConfigs = $domainsConfigLoader->loadDomainConfigsFromYaml($domainsConfigFilepath, $domainsUrlsConfigFilepath);

		$this->assertGreaterThan(0, count($domainConfigs));

		foreach ($domainConfigs as $domainConfig) {
			$this->assertInstanceOf(DomainConfig::class, $domainConfig);
		}
	}

	public function testLoadDomainConfigsFromYamlConfigFileNotFound() {
		$domainsConfigLoader = $this->getContainer()->get(DomainsConfigLoader::class);
		/* @var $domainsConfigLoader \SS6\ShopBundle\Component\Domain\Config\DomainsConfigLoader */
		$domainsUrlsConfigFilepath = $this->getContainer()->getParameter('ss6.domain_urls_config_filepath');

		$this->setExpectedException(\Symfony\Component\Filesystem\Exception\FileNotFoundException::class);
		$domainsConfigLoader->loadDomainConfigsFromYaml('nonexistentFilename', $domainsUrlsConfigFilepath);
	}

	public function testLoadDomainConfigsFromYamlUrlsConfigFileNotFound() {
		$domainsConfigLoader = $this->getContainer()->get(DomainsConfigLoader::class);
		/* @var $domainsConfigLoader \SS6\ShopBundle\Component\Domain\Config\DomainsConfigLoader */
		$domainsConfigFilepath = $this->getContainer()->getParameter('ss6.domain_config_filepath');

		$this->setExpectedException(\Symfony\Component\Filesystem\Exception\FileNotFoundException::class);
		$domainsConfigLoader->loadDomainConfigsFromYaml($domainsConfigFilepath, 'nonexistentFilename');
	}

}
