<template lang="html">
<form method="post" @submit.prevent="onSubmit">
    <p>список товаров</p>
    <button type="submit" name="button">Отправить</button>
</form>
</template>

<script>
export default {
    method: {
        onSubmit: function() {
            console.log('send form');
        },
    },
}
</script>

<style lang="scss">
</style>
