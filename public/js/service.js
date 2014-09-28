$(document).ready(function() {
  Service = {
    api: 'http://localhost:8888/rest/',
    ajax: function(config) {
      return $.ajax(config);
    },
    findAll: function(entity) {
      var config = {url: this.api.concat(entity)};
      return this.ajax(config);
    },
    find: function(entity, id) {
      var config = {url: this.api.concat(entity+'/'+id)};
      return this.ajax(config);
    },
    save: function(entity, data) {
      var config = {method: 'POST', url: this.api.concat(entity+'/save'), data: data};
      return this.ajax(config);
    },
    delete: function(entity, id) {
      var config = {method: 'DELETE', url: this.api.concat(entity+'/delete/'+id)};
      return this.ajax(config);
    }
  };
});