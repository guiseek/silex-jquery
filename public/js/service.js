$(document).ready(function() {
  Service = {
    api: 'http://localhost:8888/rest/',
    entity: null,
    ajax: function(config) {
      return $.ajax(config);
    },
    setEntity: function(entity) {
      this.entity = entity;
    },
    findAll: function() {
      var config = {url: this.api.concat(this.entity)};
      return this.ajax(config);
    },
    find: function(id) {
      var config = {url: this.api.concat(this.entity+'/'+id)};
      return this.ajax(config);
    },
    create: function(data) {
      var config = {method: 'POST', url: this.api.concat(this.entity+'/'), data: data};
      return this.ajax(config);
    },
    update: function(id, data) {
      var config = {method: 'PUT', url: this.api.concat(this.entity+'/'+id), data: data};
      return this.ajax(config);
    },
    delete: function(id) {
      var config = {method: 'DELETE', url: this.api.concat(this.entity+'/'+id)};
      return this.ajax(config);
    }
  };
});