<?php
namespace Blocks;

/**
 *
 */
class UrlHelper
{
	/**
	 * Get the URL to a resource that's located in either blocks/app/resources or a plugin's resources folder
	 *
	 * @static
	 * @param string $path
	 * @param null   $params
	 * @param string $protocol protocol to use (e.g. http, https). If empty, the protocol used for the current request will be used.
	 * @return string The URL to the resource, via Blocks' resource server
	 */
	public static function generateResourceUrl($path = '', $params = null, $protocol = '')
	{
		$origPath = $path;
		$path = Blocks::app()->config->getItem('resourceTriggerWord').'/'.trim($path, '/');
		$path = self::_normalizePath($path, $params);
		$path = Blocks::app()->request->getHostInfo($protocol).HtmlHelper::normalizeUrl($path);
		return $origPath == '' ? $path.'/' : $path;
	}

	/**
	 * @static
	 * @param string $path
	 * @param null   $params
	 * @param string $protocol protocol to use (e.g. http, https). If empty, the protocol used for the current request will be used.
	 * @return array|string
	 */
	public static function generateActionUrl($path = '', $params = null, $protocol = '')
	{
		$origPath = $path;
		$path = Blocks::app()->config->getItem('actionTriggerWord').'/'.trim($path, '/');
		$path = self::_normalizePath($path, $params);
		$path = Blocks::app()->request->getHostInfo($protocol).HtmlHelper::normalizeUrl($path);
		return $origPath == '' ? $path.'/' : $path;
	}

	/**
	 * @static
	 * @param      $path
	 * @param null $params
	 * @param string $protocol protocol to use (e.g. http, https). If empty, the protocol used for the current request will be used.
	 * @return array|string
	 */
	public static function generateUrl($path = '', $params = null, $protocol = '')
	{
		$origPath = $path;
		$path = self::_normalizePath(trim($path, '/'), $params);
		$path = Blocks::app()->request->getHostInfo($protocol).HtmlHelper::normalizeUrl($path);
		return $origPath == '' ? $path.'/' : $path;
	}

	/**
	 * @static
	 * @param        $path
	 * @param        $params
	 * @return array|string
	 */
	private static function _normalizePath($path, $params)
	{
		$path = '/'.$path;

		if (is_array($params))
			return array_merge(array($path), $params);

		if (is_string($params))
		{
			$params = ltrim($params, '?&');

			if (Blocks::app()->request->urlFormat == UrlFormat::PathInfo)
				return array($path.'?'.$params);

			return array($path.'&'.$params);
		}

		return array($path);

	}
}
