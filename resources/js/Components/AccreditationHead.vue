<template>
    <div class="w-full p-1.5 pb-0 flex gap-2 border-b border-slate-300 bg-[#F3F8F5] z-10 top-0 sticky">
        <div class="flex gap-2">

            <Link href="/accreditation/get/" 
            class="hover:accredit-active accredit" 
            :class="[$page.url === '/accreditation/get/' ? 'accredit-active' : 'border-transparent']">
                <div>Accreditation</div>
            </Link>

            <Link href="/accreditation/instrument" 
            class="hover:accredit-active accredit" 
            :class="[$page.url.startsWith('/accreditation/instrument') ? 'accredit-active' : 'border-transparent']">
                <div>Instrument</div>
            </Link>

        </div>

        <slot></slot>
    </div>
    
    <slot name="subNav"></slot>
</template>
