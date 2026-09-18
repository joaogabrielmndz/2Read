# Data dictionary

## pages

| Column | Type | Null | Default | Key |
| --- | --- | --- | --- | --- |
| id | bigint | no | nextval('pages_id_seq'::regclass) | PK |
| hash_url | character varying(255) | no |  |  |
| page_url | character varying(255) | no |  |  |
| title | character varying(255) | no |  |  |
| content | text | no |  |  |
| scrapping_status | character varying(255) | no |  |  |
| created_at | timestamp(0) without time zone | yes |  |  |
| updated_at | timestamp(0) without time zone | yes |  |  |
| deleted_at | timestamp(0) without time zone | yes |  |  |

## personal_access_tokens

| Column | Type | Null | Default | Key |
| --- | --- | --- | --- | --- |
| id | bigint | no | nextval('personal_access_tokens_id_seq'::regclass) | PK |
| tokenable_type | character varying(255) | no |  |  |
| tokenable_id | bigint | no |  |  |
| name | text | no |  |  |
| token | character varying(64) | no |  |  |
| abilities | text | yes |  |  |
| last_used_at | timestamp(0) without time zone | yes |  |  |
| expires_at | timestamp(0) without time zone | yes |  |  |
| created_at | timestamp(0) without time zone | yes |  |  |
| updated_at | timestamp(0) without time zone | yes |  |  |

Indexes: personal_access_tokens_expires_at_index (expires_at); personal_access_tokens_token_unique (token) UNIQUE; personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)

## user_page

| Column | Type | Null | Default | Key |
| --- | --- | --- | --- | --- |
| id | bigint | no | nextval('user_page_id_seq'::regclass) | PK |
| user_id | bigint | no |  | FK |
| page_id | bigint | no |  | FK |
| custom_title | character varying(255) | no |  |  |
| is_read | boolean | no | false |  |
| is_archived | boolean | no | false |  |
| created_at | timestamp(0) without time zone | yes |  |  |
| updated_at | timestamp(0) without time zone | yes |  |  |

Foreign keys: page_id -> pages.id (on delete: cascade, on update: no action); user_id -> users.id (on delete: cascade, on update: no action)

## users

| Column | Type | Null | Default | Key |
| --- | --- | --- | --- | --- |
| id | bigint | no | nextval('users_id_seq'::regclass) | PK |
| name | character varying(255) | no |  |  |
| email | character varying(255) | no |  |  |
| email_verified_at | timestamp(0) without time zone | yes |  |  |
| password | character varying(255) | no |  |  |
| remember_token | character varying(100) | yes |  |  |
| created_at | timestamp(0) without time zone | yes |  |  |
| updated_at | timestamp(0) without time zone | yes |  |  |

Indexes: users_email_unique (email) UNIQUE
