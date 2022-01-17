<template>

      <el-container class="zhuc">
        <el-header height="100px">
            <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect"  text-color="#fff"
  active-text-color="#ffd04b" router>
              <el-menu-item index="/twoc">系统管理</el-menu-item>
              <el-menu-item index="/onec">编辑科目</el-menu-item>
              <el-menu-item index="/threec">科目列表</el-menu-item>

              <el-menu-item index="/threec" class="w-right-1">仿真控制</el-menu-item>
              <el-menu-item index="/threec" class="w-right-2">资源管理</el-menu-item>
              <el-menu-item index="/threec" class="w-right-3">数据分析</el-menu-item>

            </el-menu>

        </el-header>
        <el-container>
          <el-aside width="40%">
              <router-view name="left"></router-view>
          </el-aside>
          <el-main>
              <router-view name="right"></router-view>
          </el-main>
        </el-container>
      </el-container>

</template>

<script>
  export default{
 data() {
      return {
        activeIndex: '1',
        activeIndex2: '1'
      };
    },
    methods: {
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      }
    }
  }
</script>

<style lang="less" scoped>
  .zhuc{
    height: 100%;
  }
  .el-header{
    background:  url(../assets/img/hea.png) no-repeat;
    background-size: 100% 100%;
    height: 80px;
  }
  .el-aside{
    background: url(../assets/img/xio.png) no-repeat;
    background-size: 100% 100%;
    min-height: 700px;
    padding: 0 10px;
  }
  .el-main{
      background: url(../assets/img/hh.png) no-repeat;
      background-size: 100% 100%;
      min-height: 700px;
  }
  .el-menu{
    background: rgba(0,0,0,0);
    top: 25%;
  }
  .w-right-1{
    position: absolute;
    right: 23%;
  }
  .w-right-2{
    position: absolute;
    right: 12%;
  }
  .w-right-3{
    position: absolute;
    right: 0;
  }
</style>
