<template>
    <div class="col-12">
        <div :class="'alert alert-' + activeClass">{{ msg }}</div>
    </div>
</template>

<script>

export default {
    props: ["msg", "activeClass"]
}
</script>
