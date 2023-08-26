<template>
    <div class="block fixed left-5 top-20">
        <h3 class="text-myCoral uppercase tracking-wide text-lg px-2 border-l-2 border-myGold">Меню</h3>
        <ul>
            <li class="before:content-['\2014'] text-myBlack font-normal my-2">
                <router-link :to="{name: 'peculiarities'}" class="mx-3  text-myBlack tracking-tight font-thin text-xl">Особенности породы</router-link>
            </li>
            <li class="before:content-['\2014'] text-myBlack font-normal  my-2">
                <router-link :to="{name: 'home'}" class="mx-3  text-myBlack tracking-tight font-thin text-xl">Питомники</router-link>
            </li>
            <li class="before:content-['\2014'] text-myBlack font-normal  my-2">
                <router-link :to="{name: 'home'}" class="mx-3  text-myBlack tracking-tight font-thin text-xl">Новости</router-link>
            </li>
            <li class="before:content-['\2014'] text-myBlack font-normal  my-2">
                <router-link :to="{name: 'home'}" class="mx-3  text-myBlack tracking-tight font-thin text-xl">Медиа</router-link>
            </li>
            <li class="before:content-['\2014'] text-myBlack font-normal  my-2">
                <router-link :to="{name: 'home'}" class="mx-3  text-myBlack tracking-tight font-thin text-xl">Админка</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Menu"
}
</script>

<style scoped>

</style>
