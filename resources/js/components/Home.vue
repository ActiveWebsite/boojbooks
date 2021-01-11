<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Home</div>

          <div class="card-body">
            <span @click="$router.push('/book-list')" class="red--text" style="cursor: pointer">Click here</span> to
            check out your book list and modify it!
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {},
};
</script>
