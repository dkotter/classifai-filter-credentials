<?php
/**
 * Plugin Name:       Filter ClassifAI Credentials
 * Plugin URI:        https://github.com/10up/classifai
 * Update URI:        https://classifaiplugin.com
 * Description:       Filter ClassifAI credentials.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Requires Plugins:  classifai
 * Author:            Darin Kotter
 * Author URI:        https://darinkotter.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       classifai-filter-credentials
 * Domain Path:       /languages
 *
 * @package classifai-filter-credentials
 */

namespace ClassifaiFilterCredentials;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter the ClassifAI Provider credentials.
 *
 * This overrides the credentials for all Providers,
 * pulling in hardcoded values.
 *
 * @param array  $credentials The credentials for the Provider.
 * @param string $provider_id The ID of the Provider.
 * @return array The filtered credentials.
 */
add_filter(
	'classifai_provider_credentials',
	static function ( $credentials, $provider_id ) {
		switch ( $provider_id ) {
			case 'aws_polly':
				$credentials['access_key_id']     = 'ACCESS_KEY_ID';
				$credentials['secret_access_key'] = 'SECRET_ACCESS_KEY';
				$credentials['aws_region']        = 'us-east-1';
				break;
			case 'azure_openai':
				$credentials['api_key']      = 'API_KEY';
				$credentials['endpoint_url'] = 'ENDPOINT_URL';
				$credentials['deployment']   = 'deployment-name';
				break;
			case 'elevenlabs_speech_to_text':
			case 'elevenlabs_text_to_speech':
				$credentials['api_key'] = 'API_KEY';
				break;
			case 'googleai_gemini_api':
			case 'googleai_images':
				$credentials['api_key'] = 'API_KEY';
				break;
			case 'ibm_watson_nlu':
				$credentials['apikey']       = 'API_KEY';
				$credentials['username']     = 'USERNAME';
				$credentials['password']     = 'PASSWORD';
				$credentials['endpoint_url'] = 'ENDPOINT_URL';
				break;
			case 'ms_azure_text_to_speech':
				$credentials['api_key']      = 'API_KEY';
				$credentials['endpoint_url'] = 'ENDPOINT_URL';
				break;
			case 'ms_computer_vision':
				$credentials['api_key']      = 'API_KEY';
				$credentials['endpoint_url'] = 'ENDPOINT_URL';
				break;
			case 'ollama':
			case 'ollama_embeddings':
			case 'ollama_multimodal':
				$credentials['endpoint_url'] = 'ENDPOINT_URL';
				break;
			case 'openai_chatgpt':
			case 'openai_embeddings':
			case 'openai_moderation':
			case 'openai_dalle':
			case 'openai_whisper':
			case 'openai_text_to_speech':
				$credentials['api_key'] = 'API_KEY';
				break;
			case 'stable_diffusion':
				$credentials['endpoint_url'] = 'ENDPOINT_URL';
				break;
			case 'togetherai_image':
				$credentials['api_key'] = 'API_KEY';
				break;
			case 'xai_grok':
				$credentials['api_key'] = 'API_KEY';
				break;
			default:
				break;
		}

		return $credentials;
	},
	10,
	2
);
