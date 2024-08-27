<template>
  <button>
    <slot /> <!-- slot button content -->
  </button>
</template>

<script>
export default {
    name: 'Button',
};
</script>

<style lang="scss" scoped>
    button {
        background: #e27730;
        color: #fff;
        border: 0px solid #e27730;
        padding: 10px 20px;
        cursor: pointer;
        transition: all;
        border-radius: 4px;

        &:hover{
            opacity: 0.9;
        }
    }
</style>