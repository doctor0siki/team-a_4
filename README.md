# Web Service Using Slim Framework 3 Skeleton Application
# this is a-team project

This is a sample web application using Slim3 for 2021 graduates intern event for CERES INC.

# ページurlと名前、機能

(09/05 15:38時点) 

サービスとして使う全ページは以下の通りです。

| rootからのurl  | ページ名             | 大まかな説明                                                 | フロント進捗 | バックエンド進捗 |
| -------------- | -------------------- | ------------------------------------------------------------ | ------------ | ---------------- |
| /              | トップ画面           | ユーザーが一番最初に目にするページです。                     | ○            | ○                |
| /login         | ログイン画面         | ログインを行うページです。                                   | ○            | ○                |
| /register      | 会員登録画面         | 新規会員登録を行うページです。                               | ○            | ○                |
| /resign        | 退会ページ           | アカウント退会の際、最終確認をするページです。               | ○            | ○                |
| /item/all_list | 一覧ページ           | moviesの動画データを全件取得し、一覧表示するページです。     | △            | △                |
| /show_item     | 動画ページ（モック） | 一覧ページのアイテムをクリックした際に進む、コンテンツのメインページ（のモック）です。 | ○            | △                |
| /post          | 動画投稿ページ       | 動画投稿を行うためのページです。                             | x            | x                |
○...とりあえず完了

△...現在開発中/不具合に対処厨

x...未着手

# Library Using

- slim/twig-view
- twig/extensions
- doctorine/dbal
- bryanjhv/slim-session
- Bootstrap4

# MVC Root

- Model (DAO)
  - app/Model
- View (TWIG)
  - app/View
- Controller (Routes)
  - app/Controller

# 