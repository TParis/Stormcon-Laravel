<h1 align="center">START</h1>
@foreach ($template->sub_items() as $item)
    <div class="flex text-center mt-1 mb-1"style="font-size: 26pt">
        <i class="fas fa-arrow-down ml-auto mr-auto"></i>
    </div>
    @include($item::view . "show", $item)
@endforeach
<div class="flex text-center mt-1 mb-1"style="font-size: 26pt">
    <i class="fas fa-arrow-down ml-auto mr-auto"></i>
</div>
<h1 align="center">END</h1>
