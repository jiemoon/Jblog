<template>
    <div id="app">
        <!-- <transition name="bounce"> -->
            <router-view></router-view>
        <!-- </transition> -->
    </div>
</template>
<script>
    export default {
        watch: {
            '$route'(to, from) {//监听路由改变
                if(! sessionStorage.getItem('token')) {
                    this.$router.replace('/login')
                }
            }
        }
    }
</script>

<style>
.panel {
  position: absolute;
  top: 0px;
  bottom: 0px;
  width: 100%;
}

.panel-top {
  height: 60px;
  line-height: 60px;
  background: #2392e2;
  color: #FFFFFF;
}

.panel-top .rightbar {
  text-align: right;
  padding-right: 35px;
}

.panel-top .logo {
    display: inline-block;
    padding: 0 20px;
    font-weight: bold;
    font-size: 24px;
    color: #324157;
}

.menu {
    height: 100%;
    border-radius: 0;
}

.el-dropdown {
    color: #FFFFFF;
}

.panel-center {
  background: #324057;
  position: absolute;
  top: 60px;
  bottom: 0px;
  overflow: hidden;
}

.panel-c-c {
  background: #f1f2f7;
  position: absolute;
  right: 0px;
  top: 0px;
  bottom: 0px;
  left: 180px;
  overflow-y: scroll;
  padding: 20px;
}
</style>
