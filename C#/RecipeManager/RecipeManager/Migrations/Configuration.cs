using RecipeManager.Models;
namespace RecipeManager.Migrations
{
    using System;
    using System.Data.Entity;
    using System.Data.Entity.Migrations;
    using System.Linq;

    internal sealed class Configuration : DbMigrationsConfiguration<RecipeManager.Models.RecipeManagerContext>
    {
        public Configuration()
        {
            AutomaticMigrationsEnabled = false;
        }

        protected override void Seed(RecipeManager.Models.RecipeManagerContext context)
        {
            context.Chefs.AddOrUpdate(x => x.Id,
                new Chef() { Id = 1, Name = "Aaron"},
                new Chef() { Id = 2, Name = "Adrian"},
                new Chef() { Id = 3, Name = "Daniel"}

            );
            context.Recipes.AddOrUpdate(x => x.Id,

                new Recipe() { Id = 1, Name = "Toastie", Serves = 1, Time = "10 minutes", Ingredient = "2 Slices of Bread, Grated Cheese and 1-2 slices of ham", 
                    Instruction = "Put as much cheese as you want on the bread, Add ham slices, grill until It's ready", ChefId = 1 },
                new Recipe() { Id = 2, Name = "Muffin", Serves = 12, Time = "30 minutes", Ingredient = "1 egg, 120ml milk, 4 tablespoons veg oil, 200g plain flour, 100g caster sugar, 2 teaspoons of baking powder, 1/2 teaspoon salt",
                Instruction = "Preheat oven to 200C / Gas Mark 6, Beat egg with a fork. Then stir in milk and oil. Sift flour into a large bowl. Add sugar, baking powder and salt. Add egg mixture to flour and stir until flour is moistened, Bake in muffin cups 2/3 for 20-30 minutes until golden brown.", ChefId =2 },
                new Recipe() { Id = 3, Name = "Pancakes", Serves = 4, Time = "30 Minutes", Ingredient = " 2 large eggs, 100g plain flour, 300ml of milk and 1tbsp of veg oil",
                Instruction = "Put the flour, eggs, milk and a pinch of salt into a bowl or large jug, then whisk to a smooth batter, Set a medium frying pan or crêpe pan over a medium heat and carefully wipe it with some oiled kitchen paper. When hot, cook your pancakes for 1 min on each side until golden, Serve", ChefId = 3 }

            );
        }
    }
}
