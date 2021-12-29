<title>{{ config("legacy.meta.$page.title") }}</title>
@if (config("legacy.meta.$page.description"))
	<meta name="description" content="{{ config("legacy.meta.$page.description") }}">
@endif
@if (config("legacy.meta.$page.keywords"))
	<meta name="keywords" content="{{ config("legacy.meta.$page.keywords") }}">
@endif