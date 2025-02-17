<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('asset/css/backend.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-icons.min.css')}}" />
  <link rel="shortcut icon" href="{{ asset('asset/images/logo.jpg') }}" />
  <title>{{ $app_name . ' | ' . $page_title}}</title>
  <style>
    * {font-family: 'cairo';}
  </style>
</head>
<body class="{{ $body_class ?? 'default-body' }}" id="page-top">
