<template>
  <div v-if="hasErrors">
    <span
      class="px-2 p-2 my-2 rounded text-sm block mb-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300"
      v-for="(error, index) in normalizedErrors"
      :key="index"
    >
      <div v-for="(item, i) in error" :key="i">
        {{ item }}
      </div>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    error: {
      type: [Array, Object, String],
      default: () => ({ example: "example Error" }),
    },
  },

  computed: {
    /**
     *
     */
    filteredErrors() {
      if (typeof this.error === "string") {
        if (this.error === "example Error") return [];
        return [this.error];
      }

      return Object.values(this.error).filter((msg) => msg !== "example Error");
    },

    normalizedErrors() {
      return this.filteredErrors.map((err) => {
        if (Array.isArray(err)) {
          return err;
        }

        if (typeof err === "object" && err !== null) {
          return Object.values(err);
        }

        return [err];
      });
    },

    hasErrors() {
      return this.normalizedErrors.length > 0;
    },
  },
};
</script>
