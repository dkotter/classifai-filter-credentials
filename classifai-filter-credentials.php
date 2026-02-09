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

/**
 * Filter the ClassifAI Provider credentials.
 *
 * This overrides the credentials for all Providers,
 * pulling in values from global constants.
 *
 * This allows you to have things like
 * define( 'CLASSIFAI_OPENAI_CHATGPT_API_KEY', 'API_KEY' );
 * in your wp-config.php file and those credentials will be used.
 *
 * @param array  $credentials The credentials for the Provider.
 * @param string $provider_id The ID of the Provider.
 * @return array The filtered credentials.
 */
add_filter(
	'classifai_provider_credentials',
	static function ( $credentials, $provider_id ) {
		// Set up our base Provider environment key.
		$provider_env_key = strtoupper( str_replace( '-', '_', "CLASSIFAI_{$provider_id}" ) );

		// Get the credentials for each Provider.
		switch ( $provider_id ) {
			case 'aws_polly':
				$access_key_id_env_key = "{$provider_env_key}_ACCESS_KEY_ID";
				if ( defined( $access_key_id_env_key ) ) {
					$credentials['access_key_id'] = constant( $access_key_id_env_key );
				}

				$secret_access_key_env_key = "{$provider_env_key}_SECRET_ACCESS_KEY";
				if ( defined( $secret_access_key_env_key ) ) {
					$credentials['secret_access_key'] = constant( $secret_access_key_env_key );
				}

				$aws_region_env_key = "{$provider_env_key}_AWS_REGION";
				if ( defined( $aws_region_env_key ) ) {
					$credentials['aws_region'] = constant( $aws_region_env_key );
				}
				break;
			case 'azure_openai':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}

				$endpoint_url_env_key = "{$provider_env_key}_ENDPOINT_URL";
				if ( defined( $endpoint_url_env_key ) ) {
					$credentials['endpoint_url'] = constant( $endpoint_url_env_key );
				}

				$deployment_env_key = "{$provider_env_key}_DEPLOYMENT";
				if ( defined( $deployment_env_key ) ) {
					$credentials['deployment'] = constant( $deployment_env_key );
				}
				break;
			case 'elevenlabs_speech_to_text':
			case 'elevenlabs_text_to_speech':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}
				break;
			case 'googleai_gemini_api':
			case 'googleai_images':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}
				break;
			case 'ibm_watson_nlu':
				$apikey_env_key = "{$provider_env_key}_APIKEY";
				if ( defined( $apikey_env_key ) ) {
					$credentials['apikey'] = constant( $apikey_env_key );
				}

				$username_env_key = "{$provider_env_key}_USERNAME";
				if ( defined( $username_env_key ) ) {
					$credentials['username'] = constant( $username_env_key );
				}

				$password_env_key = "{$provider_env_key}_PASSWORD";
				if ( defined( $password_env_key ) ) {
					$credentials['password'] = constant( $password_env_key );
				}

				$endpoint_url_env_key = "{$provider_env_key}_ENDPOINT_URL";
				if ( defined( $endpoint_url_env_key ) ) {
					$credentials['endpoint_url'] = constant( $endpoint_url_env_key );
				}
				break;
			case 'ms_azure_text_to_speech':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}

				$endpoint_url_env_key = "{$provider_env_key}_ENDPOINT_URL";
				if ( defined( $endpoint_url_env_key ) ) {
					$credentials['endpoint_url'] = constant( $endpoint_url_env_key );
				}
				break;
			case 'ms_computer_vision':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}

				$endpoint_url_env_key = "{$provider_env_key}_ENDPOINT_URL";
				if ( defined( $endpoint_url_env_key ) ) {
					$credentials['endpoint_url'] = constant( $endpoint_url_env_key );
				}
				break;
			case 'ollama':
			case 'ollama_embeddings':
			case 'ollama_multimodal':
				$endpoint_url_env_key = "{$provider_env_key}_ENDPOINT_URL";
				if ( defined( $endpoint_url_env_key ) ) {
					$credentials['endpoint_url'] = constant( $endpoint_url_env_key );
				}
				break;
			case 'openai_chatgpt':
			case 'openai_embeddings':
			case 'openai_moderation':
			case 'openai_dalle':
			case 'openai_whisper':
			case 'openai_text_to_speech':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}
				break;
			case 'stable_diffusion':
				$endpoint_url_env_key = "{$provider_env_key}_ENDPOINT_URL";
				if ( defined( $endpoint_url_env_key ) ) {
					$credentials['endpoint_url'] = constant( $endpoint_url_env_key );
				}
				break;
			case 'togetherai_image':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}
				break;
			case 'xai_grok':
				$api_key_env_key = "{$provider_env_key}_API_KEY";
				if ( defined( $api_key_env_key ) ) {
					$credentials['api_key'] = constant( $api_key_env_key );
				}
				break;
			default:
				break;
		}

		return $credentials;
	},
	10,
	2
);
