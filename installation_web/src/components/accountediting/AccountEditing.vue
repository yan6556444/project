<template>
  <!-- 编辑科目 -->
  <el-container class="nei-con">
    <el-main>
      <!-- 主题部分 -->
      <el-tabs>
        <el-tab-pane>
          <span slot="label"><i class="el-icon-date"></i> 新建科目</span>
          <!-- 进度条 -->
          <el-row class="fu">
            <el-col :span="24" class="ju">
              <div class="grid-content bg-purple-dark">
                <el-steps :active="active" finish-status="success" align-center>
                  <el-step :title="biao1"></el-step>
                  <el-step :title="biao2"></el-step>
                  <el-step :title="biao3"></el-step>
                  <el-step :title="biao4"></el-step>
                </el-steps>

                <!-- <el-button style="margin-top: 12px;" @click="next">下一步</el-button> -->
              </div>
            </el-col>

          </el-row>
          <el-form :model="settings" :rules="rules" ref="tabOneForm">
            <!-- 科目类别~文件名称 -->
            <div v-show="tab1">
              <el-row>
                <el-col :span="12" class="w">
                  <template>
                    <el-form-item prop="accountCategory">
                      科目类别&nbsp;
                      <el-select v-model="settings.accountCategory" clearable>
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                        </el-option>
                      </el-select>
                    </el-form-item>
                  </template>
                </el-col>
                <el-col :span="12" class="w p-9">
                  <el-form-item prop="fileName">
                    输入文件名称&nbsp;&nbsp;<el-input v-model="settings.fileName" clearable placeholder="请输入文件名称"></el-input>
                  </el-form-item>
                </el-col>
              </el-row>
              <!-- 科目类别 -->
              <el-row>
                <el-col :span="12" class="w">
                  <template class="w">
                    <el-form-item prop="accountNumber">
                      科目编号&nbsp;&nbsp;<el-select v-model="settings.accountNumber" placeholder="请选择" clearable>
                        <el-option v-for="item in options2" :key="item.value" :label="item.label" :value="item.value">
                        </el-option>
                      </el-select>
                    </el-form-item>
                  </template>
                </el-col>
              </el-row>
              <!-- 参数文字表格 -->
              <el-row>
                <el-col :span="3" class="d-text-box">
                  <div class="d-text">
                    半潜平台
                  </div>
                  <div class="d-text">
                    &nbsp;&nbsp;&nbsp;&nbsp;托轮
                  </div>
                  <div class="d-text">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;锚
                  </div>
                </el-col>
                <el-col :span="21" class="w">
                  <template>
                    <table>
                      <tr>
                        <td>
                          <input type="text" v-model="settings.semiSubmersiblePlatform.longitude" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.semiSubmersiblePlatform.latitude" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.semiSubmersiblePlatform.heave" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.semiSubmersiblePlatform.heeling" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.semiSubmersiblePlatform.trim" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.semiSubmersiblePlatform.yaw" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" v-model="settings.tug.longitude" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.tug.latitude" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.tug.heave" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.tug.heeling" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.tug.trim" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.tug.yaw" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" v-model="settings.anchorSetting.longitude" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.anchorSetting.latitude" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.anchorSetting.heave" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.anchorSetting.heeling" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.anchorSetting.trim" />
                        </td>
                        <td>
                          <input type="text" v-model="settings.anchorSetting.yaw" />
                        </td>
                      </tr>
                    </table>
                  </template>
                </el-col>

              </el-row>
              <!-- 参数设置 1-->
              <el-row>
                <el-col :span="8" class="w lp2">
                  <el-form-item prop="anchor">
                    &nbsp;&nbsp;选取锚
                    &nbsp;<el-select v-model="settings.anchor" class="sel-w" clearable>
                      <el-option v-for="item in options3" :key="item.value" :label="item.label" :value="item.value">
                      </el-option>
                    </el-select>
                  </el-form-item>
                </el-col>
                <el-col :span="8" class="w lp2">
                  <el-form-item prop="anchorType">
                    &nbsp;&nbsp;选取锚类型
                    <el-select v-model="settings.anchorType" class="sel-w" clearable>
                      <el-option v-for="item in options4" :key="item.value" :label="item.label" :value="item.value">
                      </el-option>
                    </el-select>
                  </el-form-item>
                </el-col>
                <el-col :span="8" class="w lp2">
                  <el-form-item prop="anchorMass">
                    &nbsp;&nbsp;锚质量
                    &nbsp;<el-input class="iw" v-model="settings.anchorMass" clearable placeholder=""></el-input>
                    kg
                  </el-form-item>
                </el-col>
              </el-row>
              <!-- 参数设置2 -->
              <el-row>
                <el-col :span="8" class="w lp2">
                  <el-form-item prop="anchorLength">
                    &nbsp;&nbsp;锚长度
                    &nbsp;<el-input class="iw2" v-model="settings.anchorLength" clearable placeholder="" :title="settings.anchorLength"></el-input>
                    m
                  </el-form-item>
                </el-col>
                <el-col :span="8" class="w lp2">
                  <el-form-item prop="workingCableLength">
                    工作缆绳长度&nbsp;<el-input class="iw2" v-model="settings.workingCableLength" clearable placeholder=""></el-input>
                    m
                  </el-form-item>
                </el-col>
                <el-col :span="8" class="w lp2">
                  <el-form-item prop="anchorChainSpecification">
                    锚链规格
                    &nbsp;<el-input class="iw2" v-model="settings.anchorChainSpecification" clearable placeholder=""></el-input>
                    mm
                  </el-form-item>
                </el-col>
              </el-row>

              <!-- 按钮 -->
              <el-row class="fu2">
                <div class="ju3">
                  <el-col :span="10" class="w">
                    <img style="margin-top: 20px;" src="../../assets/img/cz.jpg" @click="next" />
                  </el-col>
                  <el-col :span="10" class="w">
                    <img style="margin-top: 20px;" src="../../assets/img/xyb.jpg" @click="next" />
                  </el-col>
                </div>
              </el-row>
            </div>
          </el-form>


          <el-form ref="tabTwoForm" :model="settings" :rules="rules">
            <div v-show="tab2">
              <!-- 参数设置3 -->
              <el-row class="">
                <div class="d-30">
                  <el-col :span="12" class="w">
                    <el-form-item prop="ballastTankOneWaterLevel">
                      1号压载舱水位
                      &nbsp;&nbsp;<el-input class="i-30" v-model="settings.ballastTankOneWaterLevel" clearable
                        placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                  <el-col :span="12" class="w">
                    <el-form-item prop="ballastTankTwoWaterLevel">
                      2号压载舱水位
                      &nbsp;&nbsp;<el-input class="i-30" v-model="settings.ballastTankTwoWaterLevel" clearable
                        placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>
              <!-- 参数设置4 -->
              <el-row class="">
                <div class="d-30">
                  <el-col :span="12" class="w">
                    <el-form-item prop="ballastTankThreeWaterLevel">
                      3号压载舱水位
                      &nbsp;&nbsp;<el-input class="i-30" v-model="settings.ballastTankThreeWaterLevel" clearable
                        placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                  <el-col :span="12" class="w">
                    <el-form-item prop="ballastTankFourWaterLevel">
                      4号压载舱水位
                      &nbsp;&nbsp;<el-input class="i-30" v-model="settings.ballastTankFourWaterLevel" clearable
                        placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>
              <!-- 参数设置5 -->
              <el-row class="">
                <div class="d-30">
                  <el-col :span="12" class="w">
                    <el-form-item>
                      侧推进器是否故障
                      &nbsp;&nbsp;&nbsp;&nbsp; <el-radio v-model="settings.theSideThrusterFaulty" label="Y">是</el-radio>
                      <el-radio v-model="settings.theSideThrusterFaulty" label="N">否</el-radio>
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>

              <!-- 参数设置5 -->
              <el-row class="">
                <div class="d-30">
                  <el-col :span="12" class="w">
                    <el-form-item>
                      方位推进器是否故障
                      &nbsp;&nbsp; <el-radio v-model="settings.theAzimuthThrusterFaulty" label="Y">是</el-radio>
                      <el-radio v-model="settings.theAzimuthThrusterFaulty" label="N">否</el-radio>
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>
              <!-- 按钮 -->
              <el-row class="fu2">
                <div class="ju3">
                  <el-col :span="10" class="w">
                    <img style="margin-top: 20px;" src="../../assets/img/cz.jpg" @click="next" />
                  </el-col>
                  <el-col :span="10" class="w">
                    <img style="margin-top: 20px;" src="../../assets/img/xyb.jpg" @click="next" />
                  </el-col>
                </div>
              </el-row>
            </div>
          </el-form>
          <!-- 设置海洋环境 -->
          <el-form :model="settings" :rules="rules" ref="tabThreeForm">
            <div v-show="tab3">
              <el-row>
                <el-col :span="24">
                  <img src="../../assets/img/hy.jpg" />
                </el-col>
              </el-row>
              <!-- 参数设置3 -->
              <el-row class="">
                <div class="">
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="windDirection">
                      &nbsp;&nbsp;&nbsp;&nbsp;风向
                      &nbsp;<el-input class="iw2" v-model="settings.windDirection" clearable placeholder=""></el-input>
                      °
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="wavePeriod">
                      波浪周期&nbsp;<el-input class="iw2" v-model="settings.wavePeriod" clearable placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="windSpeed">
                      &nbsp;&nbsp;&nbsp;&nbsp;风速
                      &nbsp;<el-input class="iw2" v-model="settings.windSpeed" clearable placeholder=""></el-input>
                      m/s
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>
              <!-- 参数设置4 -->
              <el-row class="">
                <div class="d-302">
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="waveDirection">
                      &nbsp;&nbsp;&nbsp;&nbsp;浪向
                      &nbsp;<el-input class="iw2" v-model="settings.waveDirection" clearable placeholder=""></el-input>
                      °
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="flowTo">
                      &nbsp;&nbsp;&nbsp;&nbsp;流向&nbsp;<el-input class="iw2" v-model="settings.flowTo" clearable
                        placeholder=""></el-input>
                      °
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="waterDepth">
                      &nbsp;&nbsp;&nbsp;&nbsp;水深
                      &nbsp;<el-input class="iw2" v-model="settings.waterDepth" clearable placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>
              <!-- 参数设置5 -->
              <el-row class="">
                <div class="d-302">
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="currentSpeed">
                      &nbsp;&nbsp;&nbsp;&nbsp;流速
                      &nbsp;<el-input class="iw2" v-model="settings.currentSpeed" clearable placeholder=""></el-input>
                      m/s
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="meaningfulWaveHeight">
                      有义波高&nbsp;<el-input class="iw2" v-model="settings.meaningfulWaveHeight" clearable placeholder=""></el-input>
                      s
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="waveHeight">
                      &nbsp;&nbsp;&nbsp;&nbsp;浪高
                      &nbsp;<el-input class="iw2" v-model="settings.waveHeight" clearable placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>

              <!-- 参数设置5 -->
              <el-row class="">
                <div class="d-302">
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="tidalHeight">
                      &nbsp;&nbsp;潮汐高
                      &nbsp;<el-input class="iw2" v-model="settings.tidalHeight" clearable placeholder=""></el-input>
                      m
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="tideLevel">
                      潮浪等级&nbsp;<el-input class="iw2" v-model="settings.tideLevel" clearable placeholder=""></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :span="8" class="w lp2">
                    <el-form-item prop="seaStateClass">
                      海况等级
                      &nbsp;<el-input class="iw2" v-model="settings.seaStateClass" clearable placeholder=""></el-input>
                    </el-form-item>
                  </el-col>
                </div>
              </el-row>
              <!-- 按钮 -->
              <el-row class="fu2">
                <div class="ju3">
                  <el-col :span="10" class="w">
                    <img style="margin-top: 20px;" src="../../assets/img/cz.jpg" @click="next" />
                  </el-col>
                  <el-col :span="10" class="w">
                    <img style="margin-top: 20px;" src="../../assets/img/bc.jpg" @click="next" />
                  </el-col>
                </div>
              </el-row>

            </div>
          </el-form>
        </el-tab-pane>
        <el-tab-pane>
          <span slot="label"><i class="el-icon-menu"></i> 打开科目</span>
          打开
        </el-tab-pane>

      </el-tabs>
    </el-main>
  </el-container>
</template>

<script>
  export default {
    data() {
      return {
        active: 0,
        biao1: "填写科目类型",
        biao2: "填写科目类型2",
        biao3: "填写海洋环境",
        biao4: "保存完成",
        tab1: true,
        tab2: false,
        tab3: false,
        settings: {
          fileName: '',
          accountCategory: '',
          accountNumber: '',
          semiSubmersiblePlatform: {
            longitude: 0,
            latitude: 0,
            heave: 0,
            heeling: 0,
            trim: 0,
            yaw: 0
          },
          tug: {
            longitude: 0,
            latitude: 0,
            heave: 0,
            heeling: 0,
            trim: 0,
            yaw: 0
          },
          anchorSetting: {
            longitude: 0,
            latitude: 0,
            heave: 0,
            heeling: 0,
            trim: 0,
            yaw: 0
          },
          anchor: '',
          anchorType: '',
          anchorMass: '',
          anchorLength: '',
          workingCableLength: '',
          anchorChainSpecification: '',
          ballastTankOneWaterLevel: '',
          ballastTankTwoWaterLevel: '',
          ballastTankThreeWaterLevel: '',
          ballastTankFourWaterLevel: '',
          theSideThrusterFaulty: 'N',
          theAzimuthThrusterFaulty: 'N',
          windDirection: '',
          wavePeriod: '',
          windSpeed: '',
          waveDirection: '',
          flowTo: '',
          waterDepth: '',
          currentSpeed: '',
          meaningfulWaveHeight: '',
          waveHeight: '',
          tidalHeight: '',
          tideLevel: '',
          seaStateClass: ''

        },

        options: [{
          value: 'FPSOInstallation',
          label: 'FPSO安装'
        }, {
          value: 'PlatformClosure',
          label: '平台大合拢'
        }, {
          value: 'MooringInstallationSimulation',
          label: '系泊安装仿真'
        }, {
          value: 'SCRSimulation',
          label: 'SCR仿真'
        }, {
          value: 'ROVSimulation',
          label: 'ROV仿真'
        }, {
          value: 'AnchorMovingSimulation',
          label: '移锚仿真'
        }],
        options2: [{
          value: '1',
          label: '布锚作业'
        }, {
          value: '2',
          label: '收锚作业'
        }],
        options3: [{
            value: '1',
            label: '左锚'
          }, {
            value: '2',
            label: '右锚'
          },
          {
            value: '3',
            label: '艉锚'
          }
        ],
        options4: [{
            value: '1',
            label: '有杆锚'
          }, {
            value: '2',
            label: '无杆锚'
          },
          {
            value: '3',
            label: '霍尔锚'
          }
        ],
        value: '',
        value2: '',
        wen: '',
        rules: {
          fileName: [{
              required: true,
              message: '文件名不能为空',
              trigger: 'blur'
            },
            {
              max: 50,
              min: 1,
              message: '名字长度在1-50之间',
              trigger: 'blur'
            }
          ],
          accountCategory: [{
            required: true,
            message: '科目类别必须选择',
            trigger: 'change'
          }],
          accountNumber: [{
            required: true,
            message: '科目编号必须选择',
            trigger: ['blur', 'change']
          }],
          anchor: [{
            required: true,
            message: '锚必须选择',
            trigger: ['blur', 'change']
          }],
          anchorType: [{
            required: true,
            message: '锚类型必须选择',
            trigger: ['blur', 'change']
          }],
          anchorMass: [{
              required: true,
              message: '锚质量必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          anchorLength: [{
              required: true,
              message: '锚长度必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          workingCableLength: [{
              required: true,
              message: '工作缆绳必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          anchorChainSpecification: [{
              required: true,
              message: '锚链规格必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          ballastTankOneWaterLevel: [{
              required: true,
              message: '1号压载舱水位必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          ballastTankTwoWaterLevel: [{
              required: true,
              message: '2号压载舱水位必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          ballastTankThreeWaterLevel: [{
              required: true,
              message: '3号压载舱水位必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          ballastTankFourWaterLevel: [{
              required: true,
              message: '4号压载舱水位必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          windDirection: [{
              required: true,
              message: '风向必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          wavePeriod: [{
              required: true,
              message: '波浪周期必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          windSpeed: [{
              required: true,
              message: '风速必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          waveDirection: [{
              required: true,
              message: '浪向必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          flowTo: [{
              required: true,
              message: '流向必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          waterDepth: [{
              required: true,
              message: '水深必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          currentSpeed: [{
              required: true,
              message: '流速必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          meaningfulWaveHeight: [{
              required: true,
              message: '有义波高必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          waveHeight: [{
              required: true,
              message: '浪高必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          tidalHeight: [{
              required: true,
              message: '潮汐高必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          tideLevel: [{
              required: true,
              message: '潮浪等级必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ],
          seaStateClass: [{
              required: true,
              message: '海况等级必须填写',
              trigger: 'blur'
            },
            {
              max: 1000,
              min: 1,
              message: '在1-1000之间',
              trigger: 'blur'
            }
          ]

        }
      };
    },

    methods: {
      next() {
        this.active++;
        if (this.active == 1) {
          this.$refs.tabOneForm.validate(async valid => {
            if (valid) {
              this.biao1 = "已完成";
              this.tab1 = false;
              this.tab2 = true;

            } else {
              this.active = 0;
              this.$message.error("请正确填写内容");
            }
          });



        }
        if (this.active == 2) {
          this.$refs.tabTwoForm.validate(async valid => {
            if (valid) {
              this.biao2 = "已完成";
              this.tab1 = false;
              this.tab2 = false;
              this.tab3 = true;
            } else {
              this.active--;
              this.$message.error("请正确填写内容");
            }
          });

        }
        if (this.active == 3) {
          this.$refs.tabThreeForm.validate(async valid => {
            if (valid) {
              this.biao3 = "已完成";

              console.log(this.settings);
              const {
                data
              } = await this.$http.post('http://127.0.0.1:80/inst/create', this.settings)
              console.log(data);
              if (data.status == 200) {
                this.$message.success(data.message);
                this.active++;
                this.biao4 = "已完成";
              } else {
                this.$message.error(data.message);
              }
            } else {
              this.active--;
              this.$message.error("请正确填写内容");
            }
          });
        }
        if (this.active > 3) this.biao4 = "已完成";


      }
    }
  }
</script>

<style lang="less" scoped>
  .nei-con {
    position: relative;
  }

  .i-30 {
    width: 30% !important;
  }

  .d-30 {
    padding: 30px 0;
    position: relative;
    left: 50px;

  }

  .d-302 {
    padding: 10px 0;
    position: relative;
    // left: 50px;

  }

  .lp {
    // padding-left: 2.3%;
  }

  .lp2 {

    // padding-left: 2.3%;
    // text-align: right;

  }

  .d-text-box {
    padding-left: 0px;
    // left: -2.3%;
  }

  .d-text {
    line-height: 36px;
    // text-align: right;
    color: rgb(172, 168, 231);
    font-weight: 500;
    font-family: "黑体";
    font-size: 14px;

    padding: 0;
    margin: 0;
    // padding-right: 27%;
  }

  table {
    width: 87%;
    border: 1px solid rgb(70, 88, 134);
    border-spacing: 0;
    border-collapse: separate;
    position: absolute;
    left: 70px;
  }

  table tr td {
    // padding: 9px 16px;
    text-align: center;
    border-bottom: 1px solid rgb(70, 88, 134);

  }

  table tr:nth-child(2n+1) {
    background: rgb(36, 53, 99);
    border: 1px solid rgb(36, 53, 99);
    border-collapse: separate;
  }

  table tr:nth-child(2n) {
    border-top: 1px solid white;

    input,
    input:focus {
      width: 90%;
      background-color: rgb(23, 43, 85);
      border: 0;
      border-color: rgb(23, 43, 85);
      outline: none;
      color: rgb(172, 168, 231);
      text-align: center;
    }
  }


  table tr td input,
  table tr td input:focus {
    width: 90%;
    background-color: rgb(36, 53, 99);
    border: 0;
    border-color: rgb(36, 53, 99);
    outline: none;
    color: rgb(172, 168, 231);
    text-align: center;
    height: 30px;
  }

  .p-9 {
    padding-left: 9%;
  }

  .el-row {
    margin-bottom: 18px;
  }

  .w {
    color: rgb(172, 168, 231);
    font-weight: 500;
    font-family: "黑体";
    font-size: 14px;
  }

  .el-input {
    width: 55%;
    background: rgb(32, 40, 91);

  }

  .el-input.iw {
    width: 35% !important;


  }

  .el-input.iw2 {
    width: 35% !important;


  }

  .el-input.iw3 {
    width: 46% !important;


  }

  .el-select {
    width: 53%;

  }

  .sel-w {
    width: 35% !important;
  }

  .el-step {}

  .fu {
    position: relative;
    height: 65px;

    .ju {
      position: absolute;
      left: 50%;
      top: 15%;
      transform: translate(-50%, -50%);
      z-index: 10000;
    }
  }

  .fu2 {
    position: relative;
    height: 50px;
    z-index: 1;

    .ju {
      position: absolute;
      left: 60%;
      top: 15%;
      transform: translate(-50%, -50%);
      z-index: 10000;
      padding-top: 20px;
      height: 40px;
      width: 80%;

      .iw3 {
        width: 30% !important;
      }
    }

    .ju2 {
      position: absolute;
      left: 60%;
      top: 15%;
      transform: translate(-50%, -50%);
      z-index: 10000;
      padding-top: 20px;
      height: 40px;
      width: 88%;

      .iw3 {
        width: 30% !important;
      }
    }

    .ju3 {
      position: absolute;
      left: 50%;
      top: 40%;
      transform: translate(-50%, -50%);
      z-index: 10000;

      height: 40px;
      width: 60%;

      .iw3 {
        width: 30% !important;
      }
    }
  }

  .el-col img {
    cursor: pointer;
  }

  .el-col img:hover {
    box-shadow: 0px 0px 3px #409EFF;
  }
</style>
