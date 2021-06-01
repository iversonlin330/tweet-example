專案建置
- 請先執行composer install安裝
```
composer install
```
- 複製.env.example檔案
```
cp .env.example .env
```
- 編輯.env檔案，填入twitter token
```
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=
```
- 還原資料庫
```
php artisan migrate
```
- Twitter Oauth登入url
```
{serverHost}/login
```
- Twitter timeline
```
{serverHost}/timeline
```
- Twitter post tweet
```
{serverHost}/createTwitter?status=yourTweetContent
```
