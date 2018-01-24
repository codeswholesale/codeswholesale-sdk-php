-- For expiration mode "expires_in"

CREATE TABLE IF NOT EXISTS access_tokens (
  client_config_id VARCHAR(255) NOT NULL,
  scope            VARCHAR(255) NOT NULL,
  access_token     VARCHAR(255) NOT NULL,
  token_type       VARCHAR(255) NOT NULL,
  expires_in       INTEGER DEFAULT NULL,
  UNIQUE (client_config_id, scope)
)

-- For expiration mode "expires"

CREATE TABLE IF NOT EXISTS access_tokens (
  client_config_id VARCHAR(255) NOT NULL,
  scope            VARCHAR(255) NOT NULL,
  access_token     VARCHAR(255) NOT NULL,
  token_type       VARCHAR(255) NOT NULL,
  expires          INTEGER DEFAULT NULL,
  UNIQUE (client_config_id, scope)
)