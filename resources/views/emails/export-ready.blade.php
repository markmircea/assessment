<x-mail::message>
# Your Export is Ready

Your export is ready to download. This link will expire in 24 hours.

<x-mail::button :url="$downloadUrl">
Download CSV
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
