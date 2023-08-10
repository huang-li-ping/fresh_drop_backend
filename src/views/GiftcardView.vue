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

      <!-- <div class="col-3">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="搜尋" @input="searchIdOrPhone" v-model="searchInput" />
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" style="margin-left: 10px" @input="searchIdOrPhone">search</button>
          </div>
        </div>
      </div> -->


      <!-- 每頁顯示...筆 -->
      <!-- <div class="col-4">
        <span>
          每頁　
          <div class="btn-group">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="defaultDropdown"
              data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
              10
            </button>
            <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
              <li><a class="dropdown-item" href="#">10</a></li>
              <li><a class="dropdown-item" href="#">20</a></li>
              <li><a class="dropdown-item" href="#">30</a></li>
            </ul>
          </div>
          　筆
        </span>
      </div> -->
      <div class="col-2 create" style="margin-left:auto">
        <button class="btn btn-primary create-btn" type="button" style="margin-left: auto; color: #fff"
          @click="openModal">新增樣式</button>
      </div>
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
          <button class="edit-button btn btn-sm btn-outline-secondary rounded-5" @click="openModal(item)">
            <font-awesome-icon icon="fa-solid fa-pen" />
          </button>
        </td>
        <td>{{ parseInt(item.giftcard_pic_no) + 3000 }}</td>
        <td>{{ item.giftcard_pic_name }}</td>
        <td>{{ item.giftcard_pic_type }}</td>
        <td><img :src="require(`./@/../../../../fresh_drop/src/assets/images/gift/${item.giftcard_defaultpic_url}`)" alt=""></td>
        <td>{{ item.giftcard_pic_date }}</td>
        <td>{{ status(item) }}</td>
        <td>
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" style="margin-left: 10px">下架</button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- 頁碼 -->
  <PageComponent :data="searchResult" @changePage="getPageData" />

  <!-- 彈窗 -->

  <div class="show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">
  

    <div class="giftcardPic">
      <img :src="uploadedImage || require(`./@/../../../../fresh_drop/src/assets/images/gift/${newData.giftcard_defaultpic_url}`)" alt="">

      <label for="fileInput" class="btn btn-primary" style="display: block; color:#fff">上傳圖片</label>
      <input id="fileInput" type="file" ref="fileInput" style="display: none" @change="handleFileUpload">
    </div>

    <label for="id">樣式編號：<input type="text" :value="parseInt(newData.giftcard_pic_no) + 3000" id="id"></label>

    <label for="name" class="inline-label">樣式名稱：<input type="text" :value="newData.giftcard_pic_name" id="name"></label>

    <label for="catagory">類別　　：<input type="text" :value="newData.giftcard_pic_type" id="catagory"></label>

    <label for="status">狀態　　：
      <select name="" id="status">
        <option value="">上架</option>
        <option value="">下架</option>
      </select></label>



    <button class="btn btn-primary col-12" style="color:#fff">存檔</button>

    <!-- 關閉按鍵 -->
    <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
      x
    </button>
 
  </div>
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
      newData: [],
      searchInput: '',
      colTitle: ["", "編號", "樣式名稱", "類別", "圖片", "上架日期", "狀態", "上下架"],
      giftcardData: [],
      searchResult: [],
      showData: [],
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
    closeModal() {
      this.showModal = false;
    },
    handleFileUpload(event) {
      const file = event.target.files[0];

      // Validate the file format and size if needed
      // For example, check if it's an image and meets size requirements

      // Read the file as a Data URL to display the uploaded image
      const reader = new FileReader();
      reader.onload = () => {
        this.uploadedImage = reader.result;
      };
      reader.readAsDataURL(file);
    },
    getGiftcardData() {
      let url = `${this.$url}giftcardRows.php`
      this.axios.get(url).then(res => {
        // res.data.forEach(item => {
        //     if (item.phone.substr(4, 1) == '-' && item.phone.length == 10) {
        //         let front4 = item.phone.substr(0, 4)
        //         let back6 = item.phone.substr(4, 6)
        //         item.phone = front4.concat('-', back6)
        //     } else if (item.phone.length !== 10) {
        //         console.log(item.phone);
        //     }
        //})
        this.giftcardData = res.data
      }).catch(err => {
        console.log(err);
      })
    },
    // giftcardPic(item) {
    //   let imgurl = require(`./@/../../../../fresh_drop/src/assets/images/gift/${item.giftcard_defaultpic_url}`);
    //   return imgurl;
    // },
    status(item){
      let status = item.giftcard_pic_status;
      if( status == 0){
        return "啟用";
      }else if( status == 1){
        return "停用";
      }
    }

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
}

.show_modal {
  border: 3px solid #1F8D61;
  border-radius: 20px;
  width: fit-content;
  padding: 30px;
  position: absolute;
  position: fixed;
  left: 40%;
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
