<?php

namespace Database\Seeders;

use App\Http\Controllers\API\Plan\UserPlanController;
use App\Models\Meal\MealType;
use App\Models\Meal\MealRecipe;
use App\Models\Plan\UserPlanMeal;
use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Models\User\UserNotification;
use App\Utils\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Add meal types
        MealType::create([
            'id' => Utils::MEAL_TYPE_BREAKFAST,
            'name' => 'Breakfast'
        ]);
        MealType::create(['id' => Utils::MEAL_TYPE_LUNCH, 'name' => 'Lunch']);
        MealType::create(['id' => Utils::MEAL_TYPE_DINNER, 'name' => 'Dinner']);
        MealType::create(['id' => Utils::MEAL_TYPE_SNACK, 'name' => 'Snack']);

        // Add fake food recipes
        //MealRecipe::factory(20)->create();
        DB::insert("INSERT INTO `male_recipes` (`id`, `meal_type_id`, `name`, `details`, `img_url`, `calories`, `vitamin_protein`, `vitamin_iron`, `vitamin_a`) VALUES
(23, 2, 'Corn Salad', 'Ingredients\r\n\r\nCorn: White corn will work here if that’s all you can find but I recommend yellow for a prettier salad.\r\nGrape tomatoes: Cherry tomatoes will work well too.\r\nEnglish cucumber: Regular slicing cucumbers can be used, just peel first.\r\nRed onion: Green onion will work in a pinch.\r\nFeta: Diced fresh mozzarella or even goat cheese is another tasty option.\r\nFresh parsley and basil: Stick with the parsley but cilantro can be used in place of basil.\r\nOlive oil: Can try with avocado oil or sunflower oil.\r\nRed wine vinegar: White wine vinegar or apple cider vinegar may be used.\r\nLemon juice: If you have lime on hand it works as well.\r\nHoney: Or equal parts sugar.\r\nFresh garlic: 1/4 tsp garlic powder will work in this specific recipe.\r\nSalt and pepper\r\n\r\nInstructions\r\n\r\nMix dressing ingredients: In a mixing bowl whisk together olive oil, red wine vinegar, lemon juice, honey, garlic, salt and pepper. Refrigerate while preparing salad.\r\nBoil water, also prepare ice bath: Bring a large pot of water to a boil. Have a large bowl of ice water ready nearby.\r\nCook corn: Once water in pot boils add corn 3 minutes.\r\nChill corn: Transfer to ice water to cool for a few minutes. Drain well.\r\nCut corn kernels, add to bowl: Cut kernels from corn then transfer to a large bowl.\r\nAdd remaining ingredients to bowl: Add tomatoes, cucumbers, red onion, feta, parsley and basil.\r\nPour over dressing, toss: Whisk dressing again then pour over salad. Toss well to coat, season with more salt as desired.', 'https://i2.wp.com/wonkywonderful.com/wp-content/uploads/2019/06/mexican-street-corn-salad-3-scaled.jpg?fit=735%2C1102&ssl=1', 150, 10.0000, 2.0000, 400.0000),
(24, 1, 'Brocoli & Cheese Omelet', 'Ingredients\r\n\r\n-2 teaspoons extra-virgin olive oil  -¼ cup finely chopped broccoli \r\n -¼ cup finely chopped spinach   -1 large egg \r\n -1 tablespoon reduced-fat milk - 2 tablespoons shredded Monterey Jack cheese  -⅛ teaspoon salt -1 tablespoon reduced-fat sour cream \r\n -1 tablespoon finely chopped chives\r\n\r\n\r\nInstructions\r\n\r\n1- Heat oil in a small nonstick skillet over medium heat. Add broccoli and spinach and cook, stirring occasionally, until bright green and tender, 2 to 4 minutes.\r\n2- Meanwhile, whisk egg and milk in a small bowl. Add the mixture to the pan and stir briefly to combine with the vegetables. Cook, tilting the pan and letting egg run under the edges, until the egg forms a thin, even layer. Continue to cook, reducing the heat if starting to brown, until just slightly wet, 1 to 2 minutes. Sprinkle with cheese and salt. Use a spatula to roll into an omelet. Serve topped with sour cream and chives.\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkgUF1gp_Q1DxWHSV7hbSzuq2zG_VRV1KuiA&usqp=CAU', 244, 12.0000, 2.0000, 200.0000),
(25, 1, 'Tuna Salad with Egg', 'Ingredients\r\n\r\n1 Cup tuna \r\n1 Egg\r\n1/4 Celery\r\n1 Spoon mayonnaise\r\n\r\n\r\nInstructions\r\n\r\n1- Open a small can of tuna (130-140 g), drain it from the water and put it in a serving bowl directly.\r\n 2- Add the boiled egg and chopped celery.\r\n 3- Add mayonnaise (preferably low fat), and mix the ingredients carefully so as not to mash the tuna and eggs too much.\r\n 4- Season with pepper and salt to taste.\r\n', 'https://www.wholesomeyum.com/wp-content/uploads/2019/04/wholesomeyum-tuna-egg-salad-recipe-2.jpg', 408, 29.0000, 3.0000, 300.0000),
(26, 3, 'Smoked Salmon ', 'Ingredients:\r\n\r\n-Whole fresh salmon fish.\r\n-Two onions cut into slices.\r\n-Two red peppers cut into slices.\r\n-Dried chili flakes, to taste.\r\n-Salt and ground black pepper, to taste.\r\n-A little uniform oil.\r\n\r\nInstructions:\r\n\r\n-Clean the salmon thoroughly, remove the sheets from them.\r\n-Dry the onion slices and red pepper slices over a well-suffocated wooden board with water, and place the fish over it.\r\n-Prepare the grill or smoking grill, feed it with woodcuts and light it.\r\n-Put the fish on top of the smoking grill at low heat, smoke for about forty minutes, then heat to cook and grill the fish within the last 20 minutes of cooking.\r\n-Raise the smoked fish with onion slices and pepper off the grill and put it in a proper serving dish, remove the skin of the fish, and serve heated next to salads and pickles.\r\n', 'http://saucyseattleite.com/wp-content/uploads/2014/02/10th-Copy1-560x372.jpg', 200, 30.0000, 5.0000, 300.0000),
(27, 3, 'Easy Spinach-Lentil Soup', 'Ingredients\r\n\r\n2 tbsp. extra-virgin olive oil. -2 carrots, peeled and diced  -2 celery stalks, diced\r\n-1 small onion, diced  -3 cloves garlic, minced   -2 tsp. cumin   -1 tsp. coriander\r\n-1/4 tsp. crushed red pepper flakes, plus more if desired    -kosher salt\r\n-Freshly ground black pepper     -1 14-oz. can diced tomatoes, with juices\r\n10 oz. lentils      -2 tsp. fresh thyme    -4 c. vegetable broth   -4 c. baby spinach\r\n\r\nInstructions\r\n\r\nIn a large pot over medium-high heat, heat olive oil. Add carrots, celery, and onion and cook until beginning to soften, 5 minutes. Add garlic, cumin, coriander, and red pepper flakes, and cook 1 minute, stirring constantly, then season with salt and pepper.\r\nAdd tomatoes, lentils, thyme, and vegetable broth and bring to a boil. Reduce heat, cover partially, and simmer until lentils are tender and soup has thickened, 20 minutes. (If most of liquid has been absorbed, add in ½ to 1 cup more water.)\r\nStir in spinach and continue cooking until wilted, 2 minutes, then season with salt and pepper.\r\n', 'https://www.skinnytaste.com/wp-content/uploads/2019/01/Lentil-Turmeric-Soup-4.jpg', 290, 10.0000, 3.0000, 350.0000),
(28, 2, 'Boiled Sweet Potato', 'Ingredients:\r\n\r\n-Sweet Potatoes – If you are boiling them whole, try to find similarly sized potatoes.\r\n-Salt – Add a little salt to the boiling water to add flavor.\r\n-Water – Use filtered water for the best results.\r\n\r\n\r\nInstructions:\r\n\r\n-Bring a large pot of salted water to a boil.Make sure you have enough water so the sweet potatoes are covered by at least  1 inch of water. It’s best to err on the side of more water rather than not enough.\r\n-Carefully add whole potatoes or chunks to the water.\r\n-Reduce heat to Medium-High and keep a slow boil throughout the duration of cooking.\r\n-Drain, mash if desired and season with butter, salt, and pepper. Serve immediately.\r\n', 'https://24.ae/images/Articles2/202239222050828W2.jpg', 360, 10.0000, 3.0000, 600.0000),
(29, 2, 'Carrot Patties', 'Ingredients:\r\n\r\n -1 pound carrots, grated -1 clove garlic, minced -4 eggs -¼ cup all-purpose flour -¼ cup bread crumbs or matzo meal -½ teaspoon salt -1 pinch ground black pepper -2 tablespoons vegetable oil\r\n\r\n\r\nInstruction:\r\n\r\n-Step 1 In a medium size mixing bowl, combine the grated carrots, garlic, eggs, flour, bread crumbs, salt and black pepper; mix well.\r\n -Step 2 Heat oil in a frying pan over medium-high heat. Make the mixture into patties, and fry until golden brown on each side.\r\n', 'https://www.adashofmegnut.com/wp-content/uploads/2012/03/Carrot-Fritters-20.jpg', 250, 12.0000, 2.0000, 540.0000),
(30, 1, 'Pumpkin Pancakes', 'Ingredients\r\n\r\n -1 ½ cups milk\r\n-1 cup pumpkin puree\r\n-1 large egg -2 tablespoons vegetable oil\r\n-2 tablespoons vinegar\r\n-2 cups all-purpose flour\r\n-3 tablespoons brown sugar\r\n-2 teaspoons baking powder\r\n-1 teaspoon baking soda\r\n-1 teaspoon ground allspice\r\n-1 teaspoon ground cinnamon\r\n-½ teaspoon ground ginger\r\n-½ teaspoon salt\r\n\r\n\r\nInstruction\r\n\r\n-Step 1 In a bowl, mix together the milk, pumpkin, egg, oil and vinegar. Combine the flour, brown sugar, baking powder, baking soda, allspice, cinnamon, ginger and salt in a separate bowl. Stir into the pumpkin mixture just enough to combine.  -Step 2 Heat a lightly oiled griddle or frying pan over medium-high heat. Pour or scoop the batter onto the griddle, using approximately 1/4 cup for each pancake. Brown on both sides and serve hot.', 'https://www.twopeasandtheirpod.com/wp-content/uploads/2020/10/healthy-pumpkin-pancakes-10.jpg', 287, 11.0000, 6.0000, 370.0000),
(31, 3, 'Honey-Paprika-Glazed Steak & Onions\r\n', 'Ingredients:\r\n\r\nIngredient Checklist\r\n2 tablespoons honey\r\n3 tablespoons extra-virgin olive oil, divided\r\n1 teaspoon smoked paprika\r\n¾ teaspoon kosher salt\r\n1 pound skirt steak (see Tips), trimmed\r\n2 medium red onions, sliced into 1/2-inch-thick rings\r\n4 sprigs Fresh parsley for garnish\r\n\r\nInstructions:\r\n\r\n1-Preheat grill to medium-high.\r\n2-Microwave honey in a small bowl on High for 10 seconds. Stir in 1 tablespoon oil, paprika, salt and 1/2 teaspoon pepper. Brush on both sides of steak. Thread onion slices onto skewers. Brush the onions with the remaining 2 tablespoons oil and season with pepper.\r\n3-Grill the steak and onions, turning once, 6 to 7 minutes total for medium-rare steak, 12 minutes total for lightly charred and tender onions. Transfer the steak to a clean cutting board to rest for 5 minutes, then thinly slice against the grain. Serve with the onions. Garnish with parsley, if desired.', 'https://imagesvc.meredithcorp.io/v3/mm/image?url=https%3A%2F%2Fstatic.onecms.io%2Fwp-content%2Fuploads%2Fsites%2F44%2F2019%2F08%2F26232747%2F4526588.jpg', 400, 27.0000, 4.2000, 307.0000),
(32, 4, 'Ginger-Beet Juice\r\n', 'Ingredients:\r\n\r\nIngredient Checklist\r\n1 medium orange, peeled and quartered\r\n3 kale leaves\r\n1 medium apple, cut into wedges\r\n1 medium carrot, peeled\r\n1 large beet, peeled and cut into wedges\r\n1 1-inch piece peeled fresh ginger\r\nIce cubes (optional)\r\n\r\nInstructions:\r\n\r\n1-Working in this order, process orange, kale, apple, carrot, beet and ginger through a juicer according to the manufacturer\'s directions. (No juicer? See Tip.)\r\n\r\n2-Fill 2 glasses with ice, if desired, and pour the juice into the glasses. Serve immediately.', 'https://imagesvc.meredithcorp.io/v3/mm/image?url=https%3A%2F%2Fstatic.onecms.io%2Fwp-content%2Fuploads%2Fsites%2F44%2F2019%2F08%2F26231110%2F3749034.jpg', 100, 2.0000, 4.4000, 400.0000),
(33, 4, 'Cranberry-Oat Energy Balls', 'Ingredients:\r\n\r\nIngredient Checklist\r\n1 cup rolled oats\r\n¾ cup dried cranberries\r\n¾ cup dried figs\r\n½ cup sunflower seed butter\r\n3 tablespoons hemp seed (see Tip)\r\n2 tablespoons honey\r\n1 ½ teaspoons vanilla extract\r\nPinch of salt\r\n\r\nInstructions:\r\n\r\n1-Combine oats, cranberries, figs, sunflower seed butter, hemp seed, honey, vanilla and salt in a food processor. Pulse until finely chopped, 10 to 20 times, then process for about 1 minute, scraping down the sides as necessary, until the mixture is crumbly but can be pressed to form a cohesive ball.\r\n2-With wet hands (to prevent the mixture from sticking to them), squeeze about 1 tablespoon of the mixture tightly between your hands and roll into a ball. Place in a storage container. Repeat with the remaining mixture.', 'https://simple-veganista.com/wp-content/uploads/2012/12/cranberry-pistachio-oatmeal-energy-bites-6.jpg', 70, 2.0000, 1.0000, 140.0000);
");

        // Add fake users
        User::factory(10)->create();
        User::first()->update(["email" => "test@email.com"]);

        // Add fake user details
        UserDetails::factory(10)->create();
        UserNotification::factory(100)->create();

        // Add fake user plan
        foreach (User::all() as $user) {
            (new UserPlanController())->calculateTarget($user->details);
        }

        // Add fake user plan meals
        UserPlanMeal::factory(40)->create();
    }
}
