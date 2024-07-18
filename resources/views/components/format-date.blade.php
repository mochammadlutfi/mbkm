
@if(!empty($selesai) && Carbon\Carbon::parse($mulai)->isSameDay($selesai) == false)
@if(Carbon\Carbon::parse($mulai)->isSameMonth($selesai))
    {{ Carbon\Carbon::parse($mulai)->translatedFormat('d') }} - {{ Carbon\Carbon::parse($selesai)->translatedFormat('d M Y') }}
@else
    {{ Carbon\Carbon::parse($mulai)->translatedFormat('d M') }} - {{ Carbon\Carbon::parse($selesai)->translatedFormat('d M Y') }}
@endif
@else
    {{ Carbon\Carbon::parse($mulai)->translatedFormat('d M Y') }}
@endif