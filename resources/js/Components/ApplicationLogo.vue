<template>
    <img :src="logoSrc" alt="Gym Cert Logo"/>
</template>

<script>
import logoSrc from '../../images/checkout/logo.png';
export default {
    data: function (){
        return {
            logoSrc: logoSrc,
        }
    }
}
</script>
