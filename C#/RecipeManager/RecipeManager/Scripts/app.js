var ViewModel = function () {
    var self = this;
    self.recipes = ko.observableArray();
    self.chefs = ko.observableArray();
    self.newRecipe = {
        Chef: ko.observable(),
        Name: ko.observable(),
        Serves: ko.observable(),
        Time: ko.observable(),
        Instruction: ko.observable(),
        Ingredient: ko.observable()
    }
    self.detail = ko.observable();
    self.error = ko.observable();
    self.update = ko.observable();
    self.change = ko.observable();
    //Update recipe
    self.editRecipe = {
        Id: ko.observable(),
        Chef: ko.observable(),
        Name: ko.observable(),
        Serves: ko.observable(),
        Time: ko.observable(),
        Instruction: ko.observable(),
        Ingredient: ko.observable()
    }
    var recipesUri = '/api/recipes/';   
    var chefsUri = '/api/chefs/';

    function ajaxHelper(uri, method, data) {
        self.error(''); // Clear error message
        return $.ajax({
            type: method,
            url: uri,
            dataType: 'json',
            contentType: 'application/json',
            data: data ? JSON.stringify(data) : null
        }).fail(function (jqXHR, textStatus, errorThrown) {
            self.error(errorThrown);
        });
    }
    function getAllRecipes() {
        ajaxHelper(recipesUri, 'GET').done(function (data) {
            self.recipes(data);
        });
    }

    self.getRecipeDetail = function (item) {
        ajaxHelper(recipesUri + item.Id, 'GET').done(function (data) {
            self.detail(data);
        });
    }

    function getChefs() {
        ajaxHelper(chefsUri, 'GET').done(function (data) {
            self.chefs(data);
        });
    }

    self.addRecipe = function (formElement) {
        
        var recipe = {
            ChefId: self.newRecipe.Chef().Id,
            Name: self.newRecipe.Name(),
            Serves: self.newRecipe.Serves(),
            Time: self.newRecipe.Time(),
            Instruction: self.newRecipe.Instruction(),
            Ingredient: self.newRecipe.Ingredient()
           
        };
     
        ajaxHelper(recipesUri, 'POST', recipe).done(function (item) {
            self.recipes.push(item);
        });
    }
    
    
    self.deleteRecipe = function (item) {
        console.log()
        ajaxHelper(recipesUri + item.Id, 'DELETE').done(function (data) {
            self.recipes.remove(item)
        });
    }

    //Update form recipe details
    self.getUpdateDetail = function (item) {
        ajaxHelper(recipesUri + item.Id, 'GET').done(function (data) {
            self.update(data);
            var i = 0;
            // debug self.updateRecipe.Chef(self.chefs()[2]);
            for (i = 0; i < self.chefs().length; i++) {
                if (self.chefs()[i].Name == data.Chef) {
                    self.editRecipe.Chef(self.chefs()[i]);
                    break;
                }
            }
            self.editRecipe.Id(data.Id),
            self.editRecipe.Chef(data.Chef),
            self.editRecipe.Name(data.Name),
            self.editRecipe.Serves(data.Serves),
            self.editRecipe.Time(data.Time)
            self.editRecipe.Ingredient(data.Ingredient),
            self.editRecipe.Instruction(data.Instruction)
        });
        
    }

    self.applyUpdate = function (formElement) {

        var newUpdate = {
            ID : self.editRecipe.Id(),
            ChefId: self.editRecipe.Chef().Id,
            ChefName:self.editRecipe.Chef().Name,
            Name: self.editRecipe.Name(),
            Serves: self.editRecipe.Serves(),
            Time: self.editRecipe.Time(),
            Instruction: self.editRecipe.Instruction(),
            Ingredient: self.editRecipe.Ingredient()

        };
        console.log(newUpdate)
        ajaxHelper(recipesUri + self.editRecipe.Id(), 'PUT', newUpdate).done(function (item) {
            //self.recipes.push(item);
           // self.recipes.remove(function (b) { return b.Id == self.editRecipe.Id(); })
            //self.recipes.push(newUpdate);
            //self.change("");
            getAllRecipes();
        });
    }

    // Fetch the initial data.
    getAllRecipes();
    getChefs();

    
};


ko.applyBindings(new ViewModel());