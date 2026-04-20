@extends('layouts.admin')

@section('title','Kalender')
@section('page_heading','Kalender Booking')

@section('content')

<form method="GET" class="mb-5">
<input type="date" name="tanggal" value="{{ $tanggal }}"
class="border px-3 py-2 rounded">
<button class="bg-blue-600 text-white px-3 py-2 rounded">Filter</button>
</form>

<div class="bg-white rounded-xl shadow overflow-x-auto">
<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3">Lapangan</th>
@for($i=8;$i<=22;$i++)
<th class="p-3 text-center">{{ $i }}:00</th>
@endfor
</tr>
</thead>

<tbody>
@foreach($lapangans as $lapangan)
<tr class="border-t">
<td class="p-3 font-semibold">{{ $lapangan->nama }}</td>

@for($i=8;$i<=22;$i++)
@php
$booked=false;
if(isset($bookings[$lapangan->id])){
foreach($bookings[$lapangan->id] as $b){
if($i >= substr($b->jam_mulai,0,2) && $i < substr($b->jam_selesai,0,2)){
$booked=true;
}
}
}
@endphp

<td class="p-2 text-center">
@if($booked)
<span class="bg-red-500 text-white px-2 py-1 rounded text-xs">
Booked
</span>
@else
<a href="{{ route('booking.create', [
$current_team,
'lapangan_id'=>$lapangan->id,
'tanggal'=>$tanggal,
'jam_mulai'=>sprintf('%02d:00',$i),
'jam_selesai'=>sprintf('%02d:00',$i+1)
]) }}"
class="bg-green-500 text-white px-2 py-1 rounded text-xs">
Kosong
</a>
@endif
</td>
@endfor

</tr>
@endforeach
</tbody>

</table>
</div>

@endsection