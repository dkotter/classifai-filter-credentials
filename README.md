# Filter ClassifAI Credentials

A WordPress plugin that demonstrates how to use the `classifai_provider_credentials` filter hooks in [ClassifAI](https://github.com/10up/classifai) to manage Provider credentials outside of the database.

## Requirements

- WordPress 6.8+
- PHP 7.4+
- [ClassifAI](https://github.com/10up/classifai) plugin

## Overview

ClassifAI stores Provider credentials (API keys, endpoint URLs, etc.) in the database by default. This plugin provides examples of how to override those credentials using filter hooks, which is useful for:

- Keeping secrets out of the database
- Managing credentials via environment variables or constants
- Using different credentials per environment (local, staging, production)

## Available Filters

ClassifAI provides two levels of credential filters:

### `classifai_provider_credentials`

Filters credentials for **all** Providers. Receives the credentials array, the Provider ID, the Feature ID, and the Feature Provider settings.

```php
add_filter(
    'classifai_provider_credentials',
    function ( $credentials, $provider_id, $feature_id, $feature_provider_settings ) {
        // Modify credentials based on provider_id, feature_id, and feature_provider_settings.
        return $credentials;
    },
    10,
    2
);
```

### `classifai_provider_credentials_{provider_id}`

Filters credentials for a **specific** Provider. Receives the credentials array, the Feature ID, and the Feature Provider settings.

```php
add_filter(
    'classifai_provider_credentials_openai_chatgpt',
    function ( $credentials, $feature_id, $feature_provider_settings ) {
        // Modify credentials for OpenAI ChatGPT only.
        // Optionally check $feature_id and $feature_provider_settings to target a specific Feature and Provider settings.
        return $credentials;
    },
    10,
    2
);
```

## Examples

This plugin includes five examples, each building on different credential strategies:

### 1. Hardcoded values

Directly sets credentials for every Provider using hardcoded strings. Useful as a starting point to understand the filter structure and see what credential keys each Provider expects.

### 2. Global constants

Reads credentials from PHP constants (e.g., defined in `wp-config.php`). Constants follow the naming pattern `CLASSIFAI_{PROVIDER_ID}_{CREDENTIAL_KEY}`.

For example, to set the OpenAI ChatGPT API key:

```php
define( 'CLASSIFAI_OPENAI_CHATGPT_API_KEY', 'sk-...' );
```

### 3. WordPress VIP environment variables

Reads credentials from [WordPress VIP environment variables](https://docs.wpvip.com/infrastructure/environments/manage-environment-variables/#h-accessing-environment-variables-in-an-application) using `vip_get_env_var()`. Uses the same naming convention as the constants example. Only runs on WordPress VIP sites.

### 4. Specific Provider filter

Uses the Provider-specific filter (`classifai_provider_credentials_openai_chatgpt`) to override credentials for a single Provider, with a VIP environment variable fallback to a global constant.

### 5. Specific Provider + Feature filter

Same as above but also checks the `$feature_id` parameter to only apply the credential override when the Provider is being used within the Title Generation Feature.

## Supported Providers

| Provider ID | Credential Keys |
|---|---|
| `aws_polly` | `access_key_id`, `secret_access_key`, `aws_region` |
| `azure_openai` | `api_key`, `endpoint_url`, `deployment` |
| `elevenlabs_speech_to_text` | `api_key` |
| `elevenlabs_text_to_speech` | `api_key` |
| `googleai_gemini_api` | `api_key` |
| `googleai_images` | `api_key` |
| `ibm_watson_nlu` | `apikey`, `username`, `password`, `endpoint_url` |
| `ms_azure_text_to_speech` | `api_key`, `endpoint_url` |
| `ms_computer_vision` | `api_key`, `endpoint_url` |
| `ollama` | `endpoint_url` |
| `ollama_embeddings` | `endpoint_url` |
| `ollama_multimodal` | `endpoint_url` |
| `openai_chatgpt` | `api_key` |
| `openai_embeddings` | `api_key` |
| `openai_moderation` | `api_key` |
| `openai_dalle` | `api_key` |
| `openai_whisper` | `api_key` |
| `openai_text_to_speech` | `api_key` |
| `stable_diffusion` | `endpoint_url` |
| `togetherai_image` | `api_key` |
| `xai_grok` | `api_key` |

## Usage

1. Copy this plugin into your `wp-content/plugins/` directory (or `wp-content/mu-plugins/` as a must-use plugin).
2. Remove the examples you don't need, keeping only the approach that fits your setup.
3. Replace placeholder values with your actual credentials or constant/environment variable names.
4. Activate the plugin.

> **Important:** This plugin is meant as a reference. Only keep one credential-loading strategy active to avoid conflicts between the examples.
