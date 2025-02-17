import React from "react";
import { View, Text, Image } from "react-native";
import { FeaturedMovieProps } from "./types/types";

export const FeaturedMovie: React.FC<FeaturedMovieProps> = ({
  title,
  releaseDate,
  year,
  rating,
  duration,
  imageUrl,
}) => {
  return (
    <View className="flex overflow-hidden z-0 flex-col mt-3.5 max-w-full rounded-xl min-h-[362px] w-[358px]">
      <View className="flex flex-col w-full rounded-none max-w-[358px]">
        <View className="flex z-10 gap-5 justify-between items-start pt-1 pr-9 pb-6 pl-1 -mt-1 rounded-xl bg-black bg-opacity-30">
          <View className="flex flex-col self-start">
            <View className="text-2xl font-bold text-white bg-blend-luminosity">
              <Text>{title}</Text>
            </View>
            <View className="flex flex-col pl-1.5 w-full text-xs font-light">
              <View className="self-start text-amber-400">
                <Text>{releaseDate}</Text>
              </View>
              <View className="flex gap-5 mt-2.5 text-white">
                <View>
                  <Text>{year}</Text>
                </View>
                <View className="px-1.5 py-px whitespace-nowrap bg-red-600">
                  <Text>{rating}</Text>
                </View>
                <View>
                  <Text>{duration}</Text>
                </View>
              </View>
            </View>
          </View>
          <Image
            accessibilityLabel={`Featured movie poster for ${title}`}
            source={{ uri: imageUrl }}
            className="object-contain shrink-0 self-end mt-28 rounded-none aspect-square w-[46px]"
          />
        </View>
      </View>
    </View>
  );
};
