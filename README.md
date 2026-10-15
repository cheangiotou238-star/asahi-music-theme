# Asahi Music Theme

輕量、高 SEO 友善的 WordPress 專屬音樂推廣佈景主題。

## 功能特色

- **自訂文章類型 `song`（單曲作品）**：支援標題、內文編輯器、精選圖片，`has_archive` 開啟，rewrite slug 為 `songs`。
- **後台自訂欄位（Meta Boxes）**：創作者名稱、作詞/作曲/編曲、插畫工作者、MP3 音檔網址（含 wp.media 媒體庫選取器）、Spotify / Apple Music / YouTube Music 連結、創作後記與靈感、完整歌詞。所有欄位皆含 nonce 驗證與 sanitize 儲存機制。
- **單曲內頁左圖右文雙欄排版**：左欄 40% `position: sticky`、右欄 60% 捲動；手機版（< 768px）自動轉為上下單欄。
- **Plyr 播放器**（sampotts/plyr）與 **Color Thief**（lokesh/color-thief）皆透過 CDN 引入；載入時自動擷取封面主色調，轉為柔和暗色系背景漸層。
- **首頁作品牆**：上方展示最新主打單曲預覽與試聽，下方以響應式 Grid 列出所有單曲。
- **SEO 結構化資料**：單曲頁自動輸出符合 Google 規範的 `MusicRecording` JSON-LD。

## 安裝

1. 將本資料夾放到 `wp-content/themes/asahi-music-theme/`。
2. 在 WordPress 後台「外觀 > 佈景主題」啟用 Asahi Music Theme。
3. 前往「單曲作品」新增單曲，上傳封面、填入欄位與 MP3 網址即可。
