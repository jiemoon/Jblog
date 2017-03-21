<template>
    <div id="app">
        <el-row class="panel">
            <el-col class="panel-top" :span="24">
                <el-col :span="16">
                    <span class="logo"> Dashboard </span>
                </el-col>
                <el-col class="rightbar" :span="8">
                    <el-dropdown trigger="click">
                        <span class="el-dropdown-link">
                            JieMoon
                            <i class="el-icon-caret-bottom el-icon--right"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item>我的信息</el-dropdown-item>
                            <el-dropdown-item>退出</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </el-col>
            </el-col>
        </el-row>
        <el-col class="panel-center" :span="24">
            <aside style="width:180px;height:100%;">
                <el-menu mode="vertical" theme="dark" default-active="1" class="menu">
                    <el-menu-item-group title="统计">
                        <el-menu-item index="1"><i class="el-icon-message"></i>导航一</el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group title="配置">
                        <el-menu-item index="2"><i class="el-icon-setting"></i>系统配置</el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group title="文章管理">
                        <el-menu-item index="3"><i class="el-icon-document"></i>文章列表</el-menu-item>
                    </el-menu-item-group>
                </el-menu>
            </aside>
            <section class="panel-c-c">
                <div class="grid-content bg-purple-light">
                    <el-col :span="24">
                        <el-breadcrumb separator="/">
                            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                            <el-breadcrumb-item>导航一</el-breadcrumb-item>
                        </el-breadcrumb>
                    </el-col>
                    <el-col :span="24" style="background-color:#fff;box-sizing: border-box;">
                        <router-view></router-view>
                    </el-col>
                </div>
            </section>
        </el-col>
    </div>
</template>
<script>
export default {
    data () {
        return {
            title: '',
            caption: '管理页面',
            menus: [],
            slider: [],
            view: '',
            mate: {}
        }
    },
    created: function () {
        this.$root.monitor = this.refesh
        var vm = this

    },
    methods: {
        sendSubMenus: function (index) {
            this.slider = this.findFromMenusByIndex(this.menus, index).subMenus
        },
        jumpTo: function (index) {
            if (index === 'exit') {
                window.location.href = window.exitPath
            } else {
                // this.refesh()
            }
        },
        refesh: function (menu) {
            var vm = this

        },
        send: function (index) {
            this.refesh(this.findFromMenusByIndex(this.slider, index))
        },
        findFromMenusByIndex (menus, index) {
            let i = menus.findIndex(v => v.index === index)
            return menus[i]
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
