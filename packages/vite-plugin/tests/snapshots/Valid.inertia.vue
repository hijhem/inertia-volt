<?php

use function InertiaVolt\Laravel\{render};

render('test', fn() => []);

?>
    

<script setup lang="ts">
defineProps<{ message: string }>()
</script>

<template>
    Hello
</template>