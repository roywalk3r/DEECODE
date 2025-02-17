import React from "react";
import { View, Text, ScrollView } from "react-native";
import { SearchBar } from "./SearchBar";
import { FeaturedMovie } from "./FeaturedMovie";
import { MovieCard } from "./MovieCard";

const trendingMovies = [
  {
    title: "Squid Game",
    releaseDate: "Sep 17, 2021",
    imageUrl:
      "https://cdn.builder.io/api/v1/image/assets/TEMP/9d74b6da0028a8ee0ab97a4b68170357c9024feecde8138dc07feaae06e07ec8?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
  },
  {
    title: "Moana 2",
    releaseDate: "Nov 21, 2024",
    imageUrl:
      "https://cdn.builder.io/api/v1/image/assets/TEMP/051e53db13b8aefaaa677873105e55745ac1ba19c1dca2093ff4472485c593dd?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
  },
  {
    title: "Gladiator II",
    releaseDate: "Nov 05, 2024",
    imageUrl:
      "https://cdn.builder.io/api/v1/image/assets/TEMP/8de79d92f0cc74acdd7ad35f4b9002e7618167dec2580310c1b867b25ddf9a48?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
  },
];

const upcomingMovies = [
  {
    title: "Movie 1",
    releaseDate: "Dec 1, 2024",
    imageUrl:
      "https://cdn.builder.io/api/v1/image/assets/TEMP/4f4028bd8184a4914d575be6b2fd100abf76708327259ddec5541f4991c6bb2f?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
  },
  {
    title: "Movie 2",
    releaseDate: "Dec 15, 2024",
    imageUrl:
      "https://cdn.builder.io/api/v1/image/assets/TEMP/24c8ca5647201bc9198d4ad719e401952268255d787dd9087b1b3ac997cc75ef?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
  },
  {
    title: "Movie 3",
    releaseDate: "Dec 30, 2024",
    imageUrl:
      "https://cdn.builder.io/api/v1/image/assets/TEMP/01e9cc48e086f26ad5ece62ea9178090ee82b9f152f4605311be7091cf142c9c?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
  },
];

export const FilmFlix: React.FC = () => {
  return (
    <ScrollView className="flex-1 bg-zinc-900">
      <View className="flex flex-col pb-40 mx-auto w-full max-w-[480px]">
        <View className="flex relative flex-col items-center w-full bg-zinc-900 min-h-[917px]">
          <View className="flex overflow-hidden relative z-0 gap-1 justify-center items-start w-full text-white border-b-2 bg-zinc-900 border-neutral-900">
            <View className="absolute self-start h-12 text-4xl w-[203px]">
              <Text accessibilityRole="header" role="heading" aria-level={1}>
                FILM FLIX
              </Text>
            </View>
            <SearchBar />
          </View>

          <FeaturedMovie
            title="Kraven The Hunter"
            releaseDate="11 December"
            year="2024"
            rating="16+"
            duration="2h 30min"
            imageUrl="https://cdn.builder.io/api/v1/image/assets/TEMP/104872b12526234f9be439aac8fc543dc993f026a8451e497eb411f567f09710?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680"
          />

          <View className="z-0 mt-3.5 text-lg font-bold text-white">
            <Text accessibilityRole="header" role="heading" aria-level={2}>
              Trending
            </Text>
          </View>

          <View className="flex z-0 gap-4 items-center mt-3.5">
            {trendingMovies.map((movie, index) => (
              <MovieCard
                key={`trending-${index}`}
                title={movie.title}
                releaseDate={movie.releaseDate}
                imageUrl={movie.imageUrl}
              />
            ))}
          </View>

          <View className="flex overflow-hidden absolute z-0 gap-5 items-center self-start bottom-[17px] h-[132px] left-[7px]">
            {upcomingMovies.map((movie, index) => (
              <MovieCard
                key={`upcoming-${index}`}
                title={movie.title}
                releaseDate={movie.releaseDate}
                imageUrl={movie.imageUrl}
              />
            ))}
          </View>
        </View>
      </View>
    </ScrollView>
  );
};
