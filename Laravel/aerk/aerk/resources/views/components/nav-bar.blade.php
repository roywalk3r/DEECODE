@props(['containerStyles' => 'border-0'])
<div x-data="{ isActive: '{{ request()->routeIs('home') ? 'true' : 'false' }}' }"

    class="{{ $containerStyles }}"
>

    <a href="{{ route('home') }}"
        :class="{'active_link': isActive}"
        @click="isActive = true"
        class="flexCenter gap-x-1"
    >
        <box-icon type='solid' name='home-smile'></box-icon>
        Home

    </a>
    <a href=""
        :class="{'active_link': !isActive}"
        @click="isActive = false"
        class="flex items-center space-x-1"
    >
        <box-icon type='solid' name='category-alt'></box-icon>
        Men
    </a>
    <a href=""
        :class="{'active_link': !isActive}"
        @click="isActive = false"
       class="flexCenter gap-x-1"
    >
        <box-icon type='solid' name='store-alt'></box-icon>
        Women
    </a>
    <a href=""
        :class="{'active_link': !isActive}"
        @click="isActive = false"
       class="flexCenter gap-x-1"
    >
        <i class="fa-solid fa-child"></i>
        Kids
    </a>
</div>

