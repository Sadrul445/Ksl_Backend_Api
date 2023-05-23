@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'Laravel')
<img src="https://kslbd.net/assets/ksl-logo.svg" class="logo" alt="KSL Logo">
@else --}}
{{-- {{ $slot }} --}}
{{-- @endif --}}
</a>
</td>
</tr>
