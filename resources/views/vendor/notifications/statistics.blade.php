<x-mail::message :logoImg="$logoImg">
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# {{ $title }}
@endif
@endif
{{-- Intro Lines --}}
## Users:
- Всего: {{ $statistics['users']['usersAllCount'] }}
- Кол-во заблокированных: {{ $statistics['users']['usersBannedCount'] }}
- За последнюю неделю: {{ $statistics['users']['newUsersLastWeek'] }}
- За предпоследнюю неделю: {{ $statistics['users']['newUsersTwoWeekAgo'] }}
- Процент прироста за неделю: {{ $statistics['users']['usersDifferencePercentWeeks'] . '%'}}

## Media:
- Кол-во фотографий: {{ $statistics['media']['photoCount'] }}
- Размер фотографий: {{ $statistics['media']['photoSizeSum'] }}
- Кол-во видео: {{ $statistics['media']['videoCount'] }}
- Размер видео: {{ $statistics['media']['videoSizeSum'] }}
- Кол-во аудио: {{ $statistics['media']['audioCount'] }}
- Размер аудио: {{ $statistics['media']['audioSizeSum'] }}
- Общий размер медиа: {{ $statistics['media']['allMediaSize'] }}

## News:
@foreach($statistics['news'] as $key => $value)
- {{$key}}: {{$value}} created
@endforeach
{{--@foreach ($introLines as $line)--}}
{{--{{ $line }}--}}

{{--@endforeach--}}

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}

{{-- Subcopy --}}
</x-mail::message>
