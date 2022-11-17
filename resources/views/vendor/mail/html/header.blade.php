<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://cdn.pixabay.com/photo/2022/10/25/07/07/pumpkins-7545052__340.jpg" class="logo" alt="Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
