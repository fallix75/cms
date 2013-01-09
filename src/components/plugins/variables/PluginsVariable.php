<?php
namespace Blocks;

/**
 * Plugin functions
 */
class PluginsVariable
{
	/**
	 * Returns a plugin.
	 *
	 * @param string $class
	 * @param bool   $enabledOnly
	 * @return PluginRecord
	 */
	public function getPlugin($class, $enabledOnly = true)
	{
		$plugin = blx()->plugins->getPlugin($class, $enabledOnly);

		if ($plugin)
		{
			return new PluginVariable($plugin);
		}
	}

	/**
	 * Returns all plugins.
	 *
	 * @param bool $enabledOnly
	 * @return array
	 */
	public function getPlugins($enabledOnly = true)
	{
		$plugins = blx()->plugins->getPlugins($enabledOnly);
		return PluginVariable::populateVariables($plugins);
	}
}
