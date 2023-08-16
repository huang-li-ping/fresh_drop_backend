<template>
  <PageTitle :title="'禮物卡管理'" />
  <div class="container">
    <div class="row">
      <!-- 搜尋框 -->

      <div class="col-4 search_bar_group">
        <div class="input-group">
          <span class="input-group-text">搜尋樣式</span>
          <input type="text" class="form-control" placeholder="請輸入名稱" @input="searchIdOrPhone" v-model="searchInput" />
          <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div>
        </div>
      </div>
    </div>

    <div class="col-2 create" style="margin-left:auto">
      <button class="btn btn-primary create-btn" @click="openAddModal" type="button" value="新增"
        style="margin-left: auto; color: #fff">新增樣式</button>
    </div>

  </div>

  <!-- 表格 -->
  <table class="table table-hover giftcard-table">
    <thead>
      <tr>
        <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in showData" :key="index">
        <td>
          <button class="edit-button btn btn-sm btn-outline-secondary rounded-5" @click="openModal(item)" value="修改">
            <font-awesome-icon icon="fa-solid fa-pen" />
          </button>
        </td>
        <td>{{ item.giftcard_pic_no }}</td>
        <td>{{ item.giftcard_pic_name }}</td>
        <td>{{ item.giftcard_pic_type }}</td>
        <td><img :src="require(`./@/../../../../fresh_drop/src/assets/images/gift/${item.giftcard_defaultpic_url}`)"
            alt=""></td>
        <td>{{ item.giftcard_pic_date }}</td>
        <td>{{ status(item) }}</td>
        <!--<td>
           <div class="input-group-append">
            <button class="btn btn-outline-primary" type="submit" name="submit" value="" @click="handleSubmit('toggle')"
              style="margin-left: 10px">下架</button> 

          </div>
        </td>-->
      </tr>
    </tbody>
  </table>
  <!-- 頁碼 -->
  <PageComponent :data="searchResult" @changePage="getPageData" />

  <!-- 修改刪除彈窗 -->

  <form id="revise_employee" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
    <div class="giftcard_show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">


      <div class="giftcardPic">
        <img
          :src="uploadedImage || require(`./@/../../../../fresh_drop/src/assets/images/gift/${newData.giftcard_defaultpic_url}`)"
          alt="">

        <label for="fileInput" class="btn btn-primary" style="display: block; color:#fff">上傳圖片</label>
        <input id="fileInput" type="file" ref="fileInput" style="display: none" @change="handleFileUpload">
      </div>

      <label for="giftcard_pic_no">樣式編號：<input type="text" :value="newData.giftcard_pic_no" id="giftcard_pic_no"
          name="giftcard_pic_no"></label>

      <label for="giftcard_pic_name" class="inline-label">樣式名稱：<input type="text" :value="newData.giftcard_pic_name"
          id="giftcard_pic_name" name="giftcard_pic_name"></label>

      <label for="giftcard_pic_type">類別　　：<input type="text" :value="newData.giftcard_pic_type" id="giftcard_pic_type"
          name="giftcard_pic_type"></label>
      <label for="giftcard_defaultpic_url">圖片路徑：<input type="text" :value="newData.giftcard_defaultpic_url"
          id="giftcard_defaultpic_url" name="giftcard_defaultpic_url"></label>
      <label for="date">上架日期　：<input type="text" :value="newData.giftcard_pic_date || currentDate()"
          id="giftcard_pic_date" name="giftcard_pic_date"></label>


      <label for="status">狀態　　：
        <select name="giftcard_pic_status" id="giftcard_pic_status" v-model="newData.giftcard_pic_status">
          <option value="0">上架</option>
          <option value="1">下架</option>
        </select></label>



      <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="修改"
        @click="handleSubmit('存檔')">存檔</button>
      <button class="btn btn-outline-secondary col-12" type="submit" name="submit" value="刪除"
        @click="handleSubmit('刪除')">刪除</button>

      <!-- 關閉按鍵 -->
      <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
        x
      </button>

    </div>
  </form>

  <!-- 新增彈窗 -->
  <form id="revise_employee" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
    <div class="giftcard_show_modal d-flex flex-column align-items-start gap-2" v-if="showAddModal">


      <div class="giftcardPic">
        <!-- <img
          :src="uploadedImage || require(`./@/../../../../fresh_drop/src/assets/images/gift/${newData.giftcard_defaultpic_url}`)"
          alt=""> -->
        <img :src="uploadedImage" alt="">

        <label for="fileInput" class="btn btn-primary" style="display: block; color:#fff">上傳圖片</label>
        <input id="fileInput" type="file" ref="fileInput" style="display: none" @change="handleFileUpload" name="image">

      </div>

      <label for="giftcard_pic_no">樣式編號：<input type="text" :value="employeeIdNum()" id="giftcard_pic_no"
          name="giftcard_pic_no"></label>

      <label for="giftcard_pic_name" class="inline-label">樣式名稱：<input type="text" value="" id="giftcard_pic_name"
          name="giftcard_pic_name"></label>

      <label for="giftcard_pic_type">類別　　：<input type="text" :value="newData.giftcard_pic_type" id="giftcard_pic_type"
          name="giftcard_pic_type"></label>
      <label for="giftcard_defaultpic_url">圖片路徑：<input type="text" v-model="imageFileName" id="giftcard_defaultpic_url"
          name="image"></label>
      <label for="date">上架日期　：<input type="text" :value="currentDate()" id="giftcard_pic_date"
          name="giftcard_pic_date"></label>


      <label for="status">狀態　　：
        <select name="giftcard_pic_status" id="giftcard_pic_status">
          <option value=0>上架</option>
          <option value=1>下架</option>
        </select></label>



      <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="新增"
        @click="handleSubmit('新增')">新增</button>

      <!-- 關閉按鍵 -->
      <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
        x
      </button>

    </div>
  </form>
</template>
<script>
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

export default {
  name: 'IngredientView',
  components: {
    PageTitle,
    PageComponent
  },
  data() {
    return {
      uploadedImage: null,
      showModal: false,
      showAddModal: false,
      newData: [],
      searchInput: '',
      colTitle: ["", "編號", "樣式名稱", "類別", "圖片", "上架日期", "狀態"],
      giftcardData: [],
      searchResult: [],
      showData: [],
      imageFileName: '',
    };
  },

  methods: {
    searchIdOrPhone() {
      console.log(this.searchInput);
      if (this.searchInput == '') {
        this.searchResult = this.giftcardData
      }
      let idResult = this.giftcardData.filter(item => {
        return item.giftcard_pic_no.includes(this.searchInput)
      })
      let phoneResult = this.giftcardData.filter(item => {
        return item.giftcard_pic_name.includes(this.searchInput)
      })
      if (idResult.length > 0) {
        this.searchResult = idResult
      } else if ((phoneResult.length > 0)) {
        this.searchResult = phoneResult
      }
    },
    getPageData(data) {
      this.showData = data
    },
    openModal(item) {
      this.showModal = true;
      this.newData = item;
      console.log(this.newData)

    },
    openAddModal() {
      this.showAddModal = true;

    },
    closeModal() {
      this.showModal = false;
      this.showAddModal = false;

    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) return;
      this.uploadImageToDB(file.name, file);
      this.uploadedImage = URL.createObjectURL(file);
      this.newData.giftcard_defaultpic_url = file.name;
    },
    uploadImageToDB(name, file) {
      let url = `${this.$url}image_add.php`;
      let params = new FormData();
      params.append("image", file);
      this.axios.post(url, params).then((res) => {
        this.imageFileName = res.data;
        //console.log(res.data)
      })

    },
    getGiftcardData() {
      let url = `${this.$url}giftcardRows.php`
      this.axios.get(url).then(res => {
        this.giftcardData = res.data
      }).catch(err => {
        console.log(err);
      })
    },

    status(item) {
      let status = item.giftcard_pic_status;
      if (status == 0) {
        return "上架";
      } else if (status == 1) {
        return "下架";
      }
    },
    currentDate() {
      const current = new Date();
      const date = `${current.getFullYear()}-${current.getMonth() + 1}-${current.getDate()}`;
      return date;
    },

    employeeIdNum() {
      const employeeIdNum = this.giftcardData.length + 1;
      return employeeIdNum;
    },
    handleSubmit(submitType) {
      let url = `${this.$url}GiftcardInsertUpdate.php`
      const formData = new FormData();
      const giftcard_pic_no = document.querySelector('#giftcard_pic_no')?.value;
      const giftcard_pic_name = document.querySelector('#giftcard_pic_name')?.value;
      const giftcard_pic_type = document.querySelector('#giftcard_pic_type')?.value;
      const giftcard_defaultpic_url = document.querySelector('#giftcard_defaultpic_url')?.value;
      const giftcard_pic_date = document.querySelector('#giftcard_pic_date')?.value;
      const giftcard_pic_status = document.querySelector('#giftcard_pic_status')?.value;

      formData.append("giftcard_pic_no", giftcard_pic_no);
      formData.append("giftcard_pic_name", giftcard_pic_name);
      formData.append("giftcard_pic_type", giftcard_pic_type);
      formData.append("giftcard_defaultpic_url", giftcard_defaultpic_url);
      formData.append("giftcard_pic_date", giftcard_pic_date);
      formData.append("giftcard_pic_status", giftcard_pic_status);
      formData.append("submit", submitType);

      this.axios.post(url, formData).then(res => {
        console.log(res);
        this.getGiftcardData();
        this.closeModal();
      }).catch(err => {
        console.error('錯誤：', err);
      })
    },

  },
  watch: {
    giftcardData: {
      handler: function () {
        this.searchResult = this.giftcardData
      },
      deep: true
    },
  },
  mounted() {
    this.getGiftcardData()
  },


};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';


.create {
  display: flex;
}

.create-btn {
  margin-left: auto;
}

table {
  margin-top: 20px;
}

.giftcard-table {
  tr {
    vertical-align: baseline;

  }

  img {
    width: 150px;
    height: 90px;
    object-fit: cover;
  }
}

.giftcard_show_modal {
  border: 3px solid #1F8D61;
  border-radius: 20px;
  width: fit-content;
  padding: 30px;
  position: absolute;
  position: fixed;
  left: 30%;
  top: 10%;
  font-weight: 700;
  background-color: #FFF7EA;
  z-index: 2;

  .giftcardPic {

    img {
      padding-top: 20px;
      padding-bottom: 10px;
      width: 480px;
      height: 300px;
      object-fit: cover;
    }

  }

  .xmark {
    right: 5px;
    top: 5px;
    position: absolute;
  }

  label {

    input {
      padding: 0 5px;
      margin-left: 5px;


    }

    select {
      height: 28px;
    }
  }

}
</style>
