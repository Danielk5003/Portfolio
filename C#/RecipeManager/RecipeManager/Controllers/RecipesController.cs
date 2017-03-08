using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Description;
using RecipeManager.Models;

namespace RecipeManager.Controllers
{
    public class RecipesController : ApiController
    {
        private RecipeManagerContext db = new RecipeManagerContext();

        // GET: api/Recipes
        public IQueryable<RecipeDTO> GetRecipes()
        {
            var recipes = from r in db.Recipes
                          select new RecipeDTO()
                          {
                              Id = r.Id,
                              Name = r.Name,
                              ChefName = r.Chef.Name,
                          };
            return recipes;
        }

        // GET: api/Recipes/5
        [ResponseType(typeof(RecipeDetailDTO))]
        public async Task<IHttpActionResult> GetRecipe(int id)
        {
            var recipe = await db.Recipes.Include(r => r.Chef).Select(r =>
                new RecipeDetailDTO()
                {
                    Id = r.Id,
                    Name = r.Name,
                    Serves = r.Serves,
                    Time = r.Time,
                    ChefName = r.Chef.Name,
                    Ingredient = r.Ingredient,
                    Instruction = r.Instruction

                }).SingleOrDefaultAsync(r => r.Id == id);
            if (recipe == null)
            {
                return NotFound();
            }

            return Ok(recipe);

        }

        // PUT: api/Recipes/5
        [ResponseType(typeof(void))]
        public async Task<IHttpActionResult> PutRecipe(int id, Recipe recipe)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            if (id != recipe.Id)
            {
                return BadRequest();
            }

            db.Entry(recipe).State = EntityState.Modified;

            try
            {
                await db.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!RecipeExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return StatusCode(HttpStatusCode.NoContent);
        }

        // POST: api/Recipes
        [ResponseType(typeof(Recipe))]
        public async Task<IHttpActionResult> PostRecipe(Recipe recipe)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            db.Recipes.Add(recipe);
            await db.SaveChangesAsync();

            db.Entry(recipe).Reference(x => x.Chef).Load();
            var dto = new RecipeDTO()
            {
                Id = recipe.Id,
                Name = recipe.Name,
                ChefName = recipe.Chef.Name
            };
            return CreatedAtRoute("DefaultApi", new { id = recipe.Id }, dto);
        }

        // DELETE: api/Recipes/5
        [ResponseType(typeof(Recipe))]
        public async Task<IHttpActionResult> DeleteRecipe(int id)
        {
            Recipe recipe = await db.Recipes.FindAsync(id);
            if (recipe == null)
            {
                return NotFound();
            }

            db.Recipes.Remove(recipe);
            await db.SaveChangesAsync();

            return Ok(recipe);
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }

        private bool RecipeExists(int id)
        {
            return db.Recipes.Count(e => e.Id == id) > 0;
        }
    }
}