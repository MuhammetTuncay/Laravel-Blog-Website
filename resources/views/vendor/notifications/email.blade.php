@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Muhammet Tuncay'),<br>
{{ config('app.name') }}
@endif

{{--"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".--}}
{{--'into your web browser:',--}}
{{--[--}}
{{--'actionText' => $actionText,--}}
{{--]--}}

{{--"Siteye ulaşmak için tıklayınız" butonuna tıklamada sorun yaşıyorsanız,--}}
{{--aşağıdaki URL'yi kopyalayıp web tarayıcınıza yapıştırın: http: //crm.test--}}
{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "\":actionText\" butonuna tıklamada sorun yaşıyorsanız, aşağıdaki URL'yi kopyalayıp\n".
    'web tarayıcınıza yapıştırın:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
